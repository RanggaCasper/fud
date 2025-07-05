<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant\Review;

class ReviewController extends Controller
{
    public function __invoke(Request $request)
    {
        $comment = Review::with(['user', 'attachments'])->orderBy('created_at', 'desc')->paginate(6);

        if ($request->ajax()) {
            return view('partials.review-list', ['comments' => $comment])->render();
        }

        return view('reviews', [
            'comments' => $comment
        ]);
    }
}
