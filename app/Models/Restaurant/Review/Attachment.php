<?php

namespace App\Models\Restaurant\Review;

use App\Models\Restaurant\Review;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'restaurant_attachments';

    protected $guarded = ['id'];

    public function review()
    {
        return $this->belongsTo(Review::class, 'restaurant_review_id');
    }
}
