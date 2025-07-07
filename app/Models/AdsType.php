<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsType extends Model
{
    protected $table = 'ads_types';

    protected $guarded = ['id'];
    
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function restaurantAds()
    {
        return $this->hasMany(RestaurantAd::class);
    }
}
