<?php

namespace App\Models\Restaurant;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'restaurants';

    protected $guarded = ['id'];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function operatingHours()
    {
        return $this->hasMany(OperatingHours::class);
    }

    public function accessibilities()
    {
        return $this->hasMany(Accessibility::class);
    }

    public function diningOptions()
    {
        return $this->hasMany(DiningOption::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function claim()
    {
        return $this->hasOne(Claim::class)->where('status', 'approved');
    }

    public function offerings()
    {
        return $this->hasMany(Offering::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getTodayOperatingHours()
    {
        $timezone = session('timezone', 'Asia/Jakarta');
        $today = \Carbon\Carbon::now($timezone)->format('l');

        $hours = $this->operatingHours->firstWhere('day', $today);

        return $hours ? $hours->operating_hours : 'Not Available';
    }

    public function isClosed()
    {
        $timezone = session('timezone', 'Asia/Jakarta');
        $today = Carbon::now($timezone)->format('l');
        $now = Carbon::now($timezone);

        $todayHours = $this->operatingHours->firstWhere('day', $today);

        if (!$todayHours || !$todayHours->operating_hours) {
            return true;
        }

        $hours = strtolower(trim($todayHours->operating_hours));

        if (str_contains($hours, 'closed')) {
            return true;
        }

        if (str_contains($hours, 'open 24 hours')) {
            return false;
        }

        $timeRanges = explode(',', $hours);

        foreach ($timeRanges as $range) {
            $range = trim(str_replace(['–', '-'], '–', $range));

            if (!str_contains($range, '–')) {
                continue;
            }

            [$start, $end] = array_map('trim', explode('–', $range));

            // Bersihkan spasi aneh
            $start = preg_replace('/\p{Zs}+/u', ' ', $start);
            $end = preg_replace('/\p{Zs}+/u', ' ', $end);

            if (!preg_match('/am|pm/i', $start) && preg_match('/(am|pm)/i', $end, $match)) {
                $start .= ' ' . $match[1];
            }

            try {
                $startTime = Carbon::parse($start, $timezone);
                $endTime = Carbon::parse($end, $timezone);

                if ($endTime->lessThanOrEqualTo($startTime)) {
                    $endTime->addDay();
                }

                if ($now->between($startTime, $endTime)) {
                    return false; // sedang buka
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return true; // tidak berada di jam buka mana pun
    }

    public function getIsClosedCached()
    {
        return cache()->remember("restaurant_{$this->id}_is_closed", now()->addMinutes(10), function () {
            return $this->isClosed();
        });
    }   
}
