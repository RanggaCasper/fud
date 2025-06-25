<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Model;

class Accessibility extends Model
{
    protected $table = 'restaurant_accessibilities';

    protected $guarded = ['id'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
