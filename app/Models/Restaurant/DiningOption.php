<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Model;

class DiningOption extends Model
{
    protected $table = 'restaurant_dining_options';

    protected $guarded = ['id'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
