<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'restaurant_payments';

    protected $guarded = ['id'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
