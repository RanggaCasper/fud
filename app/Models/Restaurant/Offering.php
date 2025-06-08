<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Model;

class Offering extends Model
{
    protected $table = 'restaurant_offerings';

    protected $guarded = ['id'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
