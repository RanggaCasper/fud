<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\PointLog;
use App\Models\PointLevel;

class Point
{
    protected static array $actionPoints = [
        'register' => 50,
        'review'   => 20,
    ];

    public static function give(User $user, string $action): void
    {
        $points = static::$actionPoints[$action] ?? 0;

        if ($points <= 0) return;

        if ($action === 'register') {
            $alreadyGiven = PointLog::where('user_id', $user->id)
                ->where('action', 'register')
                ->exists();

            if ($alreadyGiven) return;
        }

        PointLog::create([
            'user_id' => $user->id,
            'points'  => $points,
            'action'  => $action,
        ]);

        $user->increment('total_points', $points);
    }

    public static function getLevel(User $user)
    {
        return PointLevel::getLevel($user->total_points);
    }

    public static function getProgressData(User $user): array
    {
        $currentPoints = $user->total_points;
        $currentLevel = \App\Models\PointLevel::getLevel($currentPoints);

        $nextLevel = \App\Models\PointLevel::where('target_points', '>', $currentLevel->target_points ?? 0)
            ->orderBy('target_points')
            ->first();

        $min = $currentLevel->target_points ?? 0;
        $max = $nextLevel->target_points ?? ($min + 100);
        $progress = ($currentPoints - $min) / max(($max - $min), 1) * 100;

        return [
            'current_points' => $currentPoints,
            'min' => $min,
            'max' => $max,
            'progress' => min(100, max(0, round($progress, 2))),
        ];
    }
}
