<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Helpers\Point;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Models\Restaurant\Review;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\Review\Like;
use Illuminate\Support\Facades\Storage;
use App\Models\Restaurant\Review\Report;
use RahulHaque\Filepond\Facades\Filepond;
use App\Models\Restaurant\Review\Attachment;

class ReviewController extends Controller
{
    public function index()
    {
        $comments = Review::with(['restaurant', 'user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('user.review', compact('comments'));
    }

    public function store(Request $request, $slug): JsonResponse
    {
        if (!User::find(Auth::id())->hasRole('user')) {
            return ResponseFormatter::error('Only users can submit reviews.', code: Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'attachments' => Rule::filepond([
                'required',
                'max:2000'
            ]),
        ]);

        try {
            $restaurant = Restaurant::where('slug', $slug)->firstOrFail();

            $existingReview = Review::where('restaurant_id', $restaurant->id)
                ->where('user_id', Auth::id())
                ->first();

            if ($existingReview) {
                return ResponseFormatter::error('You have already reviewed this restaurant.', code: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $review = Review::create([
                'restaurant_id' => $restaurant->id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            if ($review) {
                Point::give(User::find(Auth::id()), 'review');
            }

            if ($request->has('attachments') && is_array($request->attachments)) {
                foreach ($request->attachments as $file) {
                    $path = Filepond::field($file)->moveTo('images/attachments/' . Str::uuid());

                    Attachment::create([
                        'source' => $path['location'],
                        'type' => 'image',
                        'restaurant_review_id' => $review->id,
                    ]);
                }
            }

            return ResponseFormatter::redirected('Review created successfully.', route('restaurant.index', ['slug' => $restaurant->slug]));
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $review = Review::with(['restaurant', 'user', 'attachments'])
                ->findOrFail($id);

            return ResponseFormatter::success('Review retrieved successfully.', $review);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function update(Request $request, $reviewId): JsonResponse
    {
        if (!User::find(Auth::id())->hasRole('user')) {
            return ResponseFormatter::error('Only users can update reviews.', code: Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'attachments' => Rule::filepond([
                'nullable',
                'max:2000'
            ]),
        ]);

        try {
            $review = Review::findOrFail($reviewId);

            if ($review->user_id !== Auth::id()) {
                return ResponseFormatter::error('You can only update your own reviews.', code: Response::HTTP_FORBIDDEN);
            }

            $review->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            if ($request->has('attachments') && is_array($request->attachments)) {
                $oldAttachments = Attachment::where('restaurant_review_id', $review->id)->get();
                foreach ($oldAttachments as $attachment) {
                    if (Storage::exists($attachment->source)) {
                        Storage::delete($attachment->source);
                    }
                    $attachment->delete();
                }

                foreach ($request->attachments as $file) {
                    $path = Filepond::field($file)->moveTo('images/attachments/' . Str::uuid());

                    Attachment::create([
                        'source' => $path['location'],
                        'type' => 'image',
                        'restaurant_review_id' => $review->id,
                    ]);
                }
            }

            $review->restaurant;

            return ResponseFormatter::redirected('Review updated successfully.', url()->previous());
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function destroy($reviewId): JsonResponse
    {
        if (!User::find(Auth::id())->hasRole('user')) {
            return ResponseFormatter::error('Only users can delete reviews.', code: Response::HTTP_FORBIDDEN);
        }

        try {
            $review = Review::findOrFail($reviewId);

            if ($review->user_id !== Auth::id()) {
                return ResponseFormatter::error('You can only delete your own reviews.', code: Response::HTTP_FORBIDDEN);
            }

            $review->delete();

            return ResponseFormatter::redirected('Review deleted successfully.', url()->previous());
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function like($reviewId): JsonResponse
    {
        if (!User::find(Auth::id())->hasRole('user')) {
            return ResponseFormatter::error('Only users can like reviews.', code: Response::HTTP_FORBIDDEN);
        }

        try {
            $review = Review::findOrFail($reviewId);

            $existingLike = Like::where('restaurant_review_id', $review->id)
                ->where('user_id', Auth::id())
                ->first();

            if ($existingLike) {
                $existingLike->delete();

                $likesCount = Like::where('restaurant_review_id', $review->id)->count();

                return ResponseFormatter::success('Review liked successfully.', [
                    'likes' => (int) $likesCount,
                    'liked' => false
                ]);
            }

            Like::create([
                'restaurant_review_id' => $review->id,
                'user_id' => Auth::id()
            ]);

            $likesCount = Like::where('restaurant_review_id', $review->id)->count();

            return ResponseFormatter::success('Review liked successfully.', [
                'likes' => (int) $likesCount,
                'liked' => true
            ]);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function report(Request $request): JsonResponse
    {
        if (!User::find(Auth::id())->hasRole('user')) {
            return ResponseFormatter::error('Only users can report comments.', code: Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'comment_id' => 'required|integer|exists:restaurant_reviews,id',
            'radio_group' => 'required|string|max:255',
        ]);

        try {
            $review = Review::find($request->comment_id);

            if ($review && $review->user_id == Auth::id()) {
                return ResponseFormatter::error('You cannot report your own comment.', code: Response::HTTP_FORBIDDEN);
            }

            $report = Report::where('restaurant_review_id', $request->comment_id)
                ->where('user_id', Auth::id())
                ->first();

            if ($report) {
                return ResponseFormatter::error('You have already reported this comment.', code: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            Report::create([
                'restaurant_review_id' => $request->comment_id,
                'user_id' => Auth::id(),
                'reason' => $request->radio_group,
            ]);

            return ResponseFormatter::created('Thanks for reporting the comment. We will review it shortly.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }
}
