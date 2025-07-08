<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdClick extends Model
{
    protected $table = 'ads_clicks';

    protected $guarded = ['id'];

    public function restaurantAd()
    {
        return $this->belongsTo(RestaurantAd::class, 'restaurant_ad_id');
    }
}
