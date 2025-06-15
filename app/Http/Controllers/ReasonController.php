<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\Restaurant\Review\Report;
use Illuminate\Support\Facades\Validator;

class ReasonController extends Controller
{
    public function __invoke(Request $request)
    {
        
        try {
            $validator = Validator::make($request->all(), [
                'comment_id' => 'required|integer|exists:restaurant_reviews,id',
                'radio-group' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(
                    $validator->errors()->first(),
                    $validator->errors()->first(),
                    422
                );
            }

            Report::create([
                'restaurant_review_id' => $request->comment_id,
                'user_id' => $request->user()->id,
                'reason' => $request->input('radio-group'),
            ]);

            return ResponseFormatter::created('Thanks for reporting the comment. We will review it shortly.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }
}
