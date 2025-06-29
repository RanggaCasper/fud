<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\Restaurant\Favorite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FavoriteController extends Controller
{
    public function index()
    {
         $favorites = Favorite::with(['restaurant'])
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->paginate(6);
                        
        return view('user.favorite', compact('favorites'));
    }

    public function store(Request $request)
    {
        if (!User::find(Auth::id())->hasRole('user')) {
            flash()->error('Only users can submit reviews.');
            return ResponseFormatter::redirected('Only users can submit reviews.', url()->previous(), Response::HTTP_FORBIDDEN);
        }
        
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        try {
            $user = $request->user();

            $exists = Favorite::where('user_id', $user->id)
                            ->where('restaurant_id', $request->restaurant_id)
                            ->exists();

            if ($exists) {
                return ResponseFormatter::error('Restaurant already in favorites.');
            }

            Favorite::create([
                'user_id' => $user->id,
                'restaurant_id' => $request->restaurant_id,
            ]);

            return ResponseFormatter::created('Restaurant added to favorites.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        try {
            $user = $request->user();

            $deleted = Favorite::where('user_id', $user->id)
                            ->where('restaurant_id', $request->restaurant_id)
                            ->delete();

            if ($deleted) {
                return ResponseFormatter::success('Restaurant removed from favorites.');
            } else {
                return ResponseFormatter::error('Favorite not found.', 404);
            }
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }

    }
}
