<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
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
            $data = Report::with(
                'user',
                'review',
                'review.user',
                'review.restaurant',
            )->get();
            // dd($data);
            return DataTables::of($data)  
                ->addColumn('no', function ($row) {  
                    static $counter = 0;  
                    return ++$counter;
                })
                ->addColumn('action', function ($row) {  
                    return Blade::render('
                        <div class="flex gap-2">
                            <x-button type="button" data-modal-target="updateModal" data-update-id="{{ $id }}" size="sm">Update</x-button>
                            <x-button type="button" color="danger" data-delete-id="{{ $id }}" size="sm">Delete</x-button>
                        </div>
                    ', ['id' => $row->id]);
                })  
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
