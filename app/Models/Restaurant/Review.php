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

    public function likes()
    {
        return $this->hasMany(Review\Like::class, 'restaurant_review_id');
    }
    
    public function reports()
    {
        return $this->hasMany(Review\Report::class, 'restaurant_review_id');
    }

    public function attachments()
    {
        return $this->hasMany(Review\Attachment::class, 'restaurant_review_id');
    }
}
