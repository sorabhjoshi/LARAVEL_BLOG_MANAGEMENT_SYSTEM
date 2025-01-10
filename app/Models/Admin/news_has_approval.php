<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class news_has_approval extends Model
{
    protected $table = 'news_has_approval';
    public $timestamps = false;
    public function news()
    {
        return $this->belongsTo(News::class, 'news_id', 'id');
    }
}
