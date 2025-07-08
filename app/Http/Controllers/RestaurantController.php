<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\RestaurantAd;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Restaurant\Claim;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Models\AdClick;
use App\Models\Restaurant\Restaurant;
use RahulHaque\Filepond\Facades\Filepond;
use Symfony\Component\HttpFoundation\Response;

class RestaurantController extends Controller
{
    public function index(Request $request, $slug)
    {
        $restaurant = Restaurant::with([
            'offerings',
            'payments',
            'diningOptions',
            'accessibilities',
            'operatingHours',
            'reviews'
        ])->where('slug', $slug)->firstOrFail();

        $source = $request->query('source');

        if (in_array($source, ['ads-restaurant', 'ads-carousel'])) {
            $type = $source === 'ads-carousel' ? 'carousel' : 'restaurant';

            $ad = RestaurantAd::with('adsType')->where('restaurant_id', $restaurant->id)
                ->where('is_active', true)
                ->where('end_date', '>=', now())
                ->whereHas('adsType', function ($query) use ($type) {
                    $query->where('type', $type);
                })
                ->first();

            if ($ad) {
                $ip = $request->ip();
                $threshold = now()->subSeconds(10);

                $recentClick = AdClick::where('restaurant_ad_id', $ad->id)
                    ->where('ip_address', $ip)
                    ->where('created_at', '>=', $threshold)
                    ->exists();

                if (!$recentClick) {
                    AdClick::create([
                        'restaurant_ad_id' => $ad->id,
                        'ip_address' => $ip,
                    ]);
                }
            }
        }

        $viewed = (array) session()->get('recently_viewed', []);
        $viewed = array_filter($viewed, fn($id) => $id != $restaurant->id);
        array_unshift($viewed, $restaurant->id);
        $viewed = array_slice($viewed, 0, 10);
        session(['recently_viewed' => $viewed]);

        return view('detail', compact('restaurant'));
    }

    public function claim(Request $request, $slug)
    {
        $restaurant = Restaurant::with('offerings', 'payments', 'diningOptions', 'accessibilities', 'operatingHours', 'reviews')->where('slug', $slug)->firstOrFail();

        if ($restaurant->claim) {
            flash()->error('This restaurant has already been claimed and approved.');
            return redirect()->back();
        }

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

            Claim::create([
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
