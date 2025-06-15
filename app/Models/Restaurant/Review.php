<?php

namespace App\Models\Restaurant;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'restaurant_reviews';
    
    protected $guarded = ['id'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reports()
    {
        return $this->hasMany(Review\Report::class, 'review_id');
    }
}
