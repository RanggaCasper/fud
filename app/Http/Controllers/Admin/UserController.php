<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users');
    }

    public function get(): JsonResponse
    {
        try {
            $data = User::with('role')->whereHas('role', function ($query) {
                        $query->where('name', 'user');
                    })->get();
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

    public function getById($id): JsonResponse
    {
        try {
            $data = User::findOrFail($id);
            return ResponseFormatter::success('Data retrived successfully.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate( [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|min:10|max:13',
            'role' => 'required|exists:roles,id',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt('password'), // Default password
                'phone' => $request->phone,
                'role_id' => Role::find($request->role)->id,
            ]);

            return ResponseFormatter::created();
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate( [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|min:10|max:13',
            'role' => 'required|exists:roles,id',
        ]);

        try {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => Role::find($request->role)->id,
            ]);

            return ResponseFormatter::success('Data updated successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return ResponseFormatter::success('Data deleted successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }
}
