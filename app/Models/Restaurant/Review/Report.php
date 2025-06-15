<?php

namespace App\Models\Restaurant\Review;

use App\Models\User;
use App\Models\Restaurant\Review;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'restaurant_review_reports';

    protected $guarded = ['id'];

    public function review()
    {
        return $this->belongsTo(Review::class, 'restaurant_review_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
