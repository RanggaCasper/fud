<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant\OperatingHours;

class OperatingHoursController extends Controller
{
    public function index()
    {
        $restaurant = Auth::user()->owned->restaurant;

        $daysOfWeek = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];

        $existingHours = $restaurant->operatingHours->keyBy('day');
        $operatingHours = collect($daysOfWeek)->map(function ($day) use ($existingHours) {
            $data = $existingHours->get($day);

            return [
                'id' => $data->id ?? null,
                'day' => $day,
                'operating_hours' => $data->operating_hours ?? '',
            ];
        });

        return view('owner.operating-hours', compact('operatingHours'));
    }

    public function update(Request $request)
    {
        try {
            $restaurant = Auth::user()->owned->restaurant;
            $hours = $request->input('hours');

            foreach ($hours as $hour) {
                $day = $hour['day'];
                $id = $hour['id'] ?? null;
                $isClosed = !empty($hour['is_closed']);
                $is24 = !empty($hour['is_24']);
                $openTimes = $hour['open'] ?? [];
                $closeTimes = $hour['close'] ?? [];

                if ($isClosed && $is24) {
                    return ResponseFormatter::error("You cannot select both 'Open 24 Hours' and 'Closed' for {$day}.", 422);
                }

                if ($isClosed) {
                    $value = 'Closed';
                } elseif ($is24) {
                    $value = 'Open 24 hours';
                } else {
                    $ranges = [];

                    for ($i = 0; $i < count($openTimes); $i++) {
                        $open = $openTimes[$i] ?? null;
                        $close = $closeTimes[$i] ?? null;

                        if ($open && $close) {
                            try {
                                $from = \Carbon\Carbon::createFromFormat('H:i', $open)->format('g A');
                                $to = \Carbon\Carbon::createFromFormat('H:i', $close)->format('g A');
                                $ranges[] = "{$from}–{$to}";
                            } catch (\Exception $e) {
                                // Skip invalid range
                            }
                        }
                    }

                    $value = count($ranges) ? implode(', ', $ranges) : 'Closed';
                }

                $operatingHour = OperatingHours::find($id) ??
                    OperatingHours::firstOrNew([
                        'restaurant_id' => $restaurant->id,
                        'day' => $day,
                    ]);

                $operatingHour->restaurant_id = $restaurant->id;
                $operatingHour->day = $day;
                $operatingHour->operating_hours = $value;
                $operatingHour->save();
            }

            return ResponseFormatter::success('Operating hours updated successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
