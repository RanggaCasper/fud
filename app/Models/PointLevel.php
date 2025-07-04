<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointLevel extends Model
{
    protected $table = 'point_levels';

    protected $guarded = ['id'];

    public static function getLevel($p)
    {
        return static::where('target_points', '<=', $p)->orderByDesc('target_points')->first();
    }
}
