<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Restaurant\Claim;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;

class OwnerController extends Controller
{
    public function index()
    {
        return view('admin.owner');
    }

    public function get(): JsonResponse
    {
        try {
            $data = Claim::with(
                'user',
                'restaurant',
                'reviewed',
            )->get();

            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('status', function ($row) {
                    $status = $row->status;

                    $color = match ($status) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        default => 'danger',
                    };

                    return Blade::render(<<<'BLADE'
                            <x-badge :color="$color" class="capitalize">
                                {{ ucfirst($status) }}
                            </x-badge>
                        BLADE, [
                        'status' => $status,
                        'color' => $color,
                    ]);
                })
                ->addColumn('proff', function ($row) {
                    return Blade::render('
                        <div class="flex gap-2">
                            <a href="{{ Storage::url($proff) }}" class="btn btn-sm btn-primary" target="_blank">
                                View
                            </a>
                        </div>
                    ', ['proff' => $row->ownership_proof]);
                })
                ->addColumn('action', function ($row) {
                    return Blade::render('
                        <div class="flex gap-2">
                            <x-button type="button" data-modal-target="updateModal" data-update-id="{{ $id }}" size="sm">Update</x-button>
                            <x-button type="button" color="danger" data-delete-id="{{ $id }}" size="sm">Delete</x-button>
                        </div>
                    ', ['id' => $row->id]);
                })
                ->rawColumns(['action', 'status', 'proff'])
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $data = Claim::findOrFail($id);
            return ResponseFormatter::success('Data retrived successfully.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate( [
            'status' => 'required|in:pending,approved,rejected',
            'note' => 'required_if:status,rejected',
        ]);

        try {
            $data = Claim::findOrFail($id);
            $data->update([
                'status' => $request->status,
                'note' => $request->note ?? null,
            ]);

            return ResponseFormatter::success('Data updated successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $user = Claim::findOrFail($id);
            $user->delete();

            return ResponseFormatter::success('Data deleted successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }
}
