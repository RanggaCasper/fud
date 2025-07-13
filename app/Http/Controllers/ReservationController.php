<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Services\PlaceDataService;
use Illuminate\Support\Facades\Http;

class ReservationController extends Controller
{
    public function getImage($place_id, PlaceDataService $placeService): JsonResponse
    {
        $result = $placeService->fetchImages($place_id);
        return response()->json($result, $result['success'] ? 200 : ($result['status'] ?? 500));
    }

    public function getReservation($place_id, PlaceDataService $placeService): JsonResponse
    {
        $result = $placeService->fetchReservationData($place_id);
        return response()->json($result, $result['success'] ? 200 : ($result['status'] ?? 500));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'date' => ['required', 'date'],
            'time' => ['required'],
            'adults' => ['required', 'integer', 'min:1'],
            'children' => ['required', 'integer', 'min:0'],
            'rid' => ['required', 'string', 'max:255'],
        ]);

        $params = [
            "date" => $request->date,
            "time" => $request->time,
            "adults" => $request->adults,
            "children" => $request->children,
            "rid" => $request->rid,
        ];

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0'
            ])->get('https://book.chope.co/booking/check', $params);

            $redirectedUrl = $response->effectiveUri() ?? null;

            return ResponseFormatter::redirected('Redirected.', $redirectedUrl);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
