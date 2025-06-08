<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Model;

class OperatingHours extends Model
{
    protected $table = 'restaurant_operating_hours';

    protected $guarded = ['id'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
