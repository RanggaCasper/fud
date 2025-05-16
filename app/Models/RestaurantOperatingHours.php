<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantOperatingHours extends Model
{
    protected $table = 'restaurant_operating_hours';

    protected $guarded = ['id'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
