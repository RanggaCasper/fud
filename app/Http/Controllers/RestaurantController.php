<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Restaurant\Claim;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Models\Restaurant\Restaurant;
use RahulHaque\Filepond\Facades\Filepond;
use Illuminate\Database\Eloquent\Casts\Json;
use Symfony\Component\HttpFoundation\Response;

class RestaurantController extends Controller
{
    public function index(Request $request, $slug)
    {
        $restaurant = Restaurant::with('offerings', 'payments', 'diningOptions', 'accessibilities', 'operatingHours', 'reviews')->where('slug', $slug)->firstOrFail();
        return view('detail', compact('restaurant'));
    }

    public function claim(Request $request, $slug)
    {
        $restaurant = Restaurant::with('offerings', 'payments', 'diningOptions', 'accessibilities', 'operatingHours', 'reviews')->where('slug', $slug)->firstOrFail();
        return view('claim', compact('restaurant'));
    }

    public function store(Request $request, $slug): JsonResponse
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        $user = $request->user();

        if ($restaurant->claim) {
            return ResponseFormatter::error('This restaurant has already been claimed and approved.', code: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($user->restaurantClaim) {
            return ResponseFormatter::error('You have already submitted a restaurant claim.', code: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $request->validate([
            'ownership_proof' => [
                'required',
                Rule::filepond(['max:2000']),
            ],
        ]);

        try {
            $path = Filepond::field($request->ownership_proof)
                ->moveTo('images/ownership/' . Str::uuid());

            $claim = Claim::create([
                'user_id'         => $user->id,
                'restaurant_id'   => $restaurant->id,
                'message'         => 'Request to claim ownership',
                'ownership_proof' => $path['location'],
                'status'          => 'pending',
            ]);

            return ResponseFormatter::success('Restaurant claim submitted successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
