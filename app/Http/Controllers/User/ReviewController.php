<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Restaurant\Restaurant;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $comments = Review::with(['restaurant', 'user']) // pastikan 'user' juga dimuat
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(6); // atau sesuai jumlah yang diinginkan

        return view('user.review', compact('comments'));
    }
    
    public function store(Request $request, $slug)
    {
        $request->validate([
            'file' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        try {
            Review::create([
                'restaurant_id' => Restaurant::where('slug', $slug)->first()->id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            return ResponseFormatter::created('Review created successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
