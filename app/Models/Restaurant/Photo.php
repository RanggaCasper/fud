<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'restaurant_photos';

    protected $guarded = ['id'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
