<?php

namespace App\Models;

use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantAd extends Model
{
    use HasFactory;

    protected $table = 'restaurant_ads';

    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function adsType()
    {
        return $this->belongsTo(AdsType::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
