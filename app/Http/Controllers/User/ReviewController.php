<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Models\Restaurant\Review;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant\Restaurant;
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
    
    public function store(Request $request, $slug)
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
}
