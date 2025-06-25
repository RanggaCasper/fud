<?php

namespace App\Models\Restaurant;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $table = 'restaurant_claims';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
