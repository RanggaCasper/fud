<?php

namespace App\Models\Restaurant;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'restaurant_favorites';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
}
