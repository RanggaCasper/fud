<?php

namespace App\Http\Controllers\User;

use App\Models\PointLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PointController extends Controller
{
    public function index()
    {
        return view('user.point');
    }

    public function get(Request $request): JsonResponse
    {
        try {
            $data = PointLog::where('user_id', $request->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('from', function ($row) {
                    return $row->action;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d H:i:s');
                })
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
