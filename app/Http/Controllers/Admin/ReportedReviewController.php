<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Restaurant\Review;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use App\Models\Restaurant\Review\Report;

class ReportedReviewController extends Controller
{
    public function index()
    {
        return view('admin.reported-reviews');
    }

    public function get(): JsonResponse
    {
        try {
            $data = Review::with([
                'user',
                'restaurant',
                'reports.user'
            ])
                ->has('reports')
                ->get()
                ->map(function ($review) {
                    $reasonCount = $review->reports->groupBy('reason')->map->count();

                    return [
                        'id' => $review->id,
                        'comment' => $review->comment,
                        'rating' => $review->rating,
                        'user_name' => $review->user?->name,
                        'restaurant_name' => $review->restaurant?->name,
                        'reports' => $review->reports,
                        'reasonCount' => $reasonCount,
                    ];
                });

            return DataTables::of($data)
                ->addColumn('no', function () {
                    static $i = 0;
                    return ++$i;
                })
                ->addColumn('total_reports', fn($row) => $row['reports']->count())
                ->addColumn('action', function ($row) {
                    return Blade::render('
                    <div class="flex gap-2">
                        <x-button type="button" data-modal-target="viewModal" data-view-id="{{ $id }}" size="sm">View</x-button>
                    </div>
                ', ['id' => $row['id']]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $review = Review::with([
                'user',
                'restaurant',
                'attachments',
                'reports.user',
            ])
                ->where('id', $id)
                ->has('reports')
                ->firstOrFail();

            $reasonCount = $review->reports->groupBy('reason')->map(function ($items) {
                return count($items);
            });

            return ResponseFormatter::success('Reported reviews retrieved successfully.', [
                'review' => $review,
                'reasonCount' => $reasonCount,
            ]);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $review = Review::findOrFail($id);
            $review->delete();

            return ResponseFormatter::success('Review deleted successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }
}
