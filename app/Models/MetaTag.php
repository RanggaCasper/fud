<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaTag extends Model
{
    protected $table = 'meta_tags';

    protected $guarded = ['id'];

    protected $casts = [
        'meta_keywords' => 'array',
    ];

    public function metaable()
    {
        return $this->morphTo();
    }
}
