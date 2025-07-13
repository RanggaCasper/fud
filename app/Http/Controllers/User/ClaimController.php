<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Restaurant\Claim;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RahulHaque\Filepond\Facades\Filepond;

class ClaimController extends Controller
{
    public function index()
    {
        return view('user.claim');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ownership_proof' => [
                'required',
                Rule::filepond(['max:2000']),
            ],
        ]);

        try {
            $data = Claim::where('user_id', Auth::id());

            $path = Filepond::field($request->ownership_proof)->moveTo('images/ownership/' . Str::uuid());

            $data->update([
                'status' => 'pending',
                'ownership_proof' => $path['location'],
            ]);

            return ResponseFormatter::redirected('Restaurant claim updated successfully.', url()->previous());
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
