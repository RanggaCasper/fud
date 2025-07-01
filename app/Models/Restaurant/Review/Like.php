<?php

namespace App\Models\Restaurant\Review;

use App\Models\User;
use App\Models\Restaurant\Review;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'restaurant_review_likes';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function review()
    {
        return $this->belongsTo(Review::class, 'restaurant_review_id');
    }
}
