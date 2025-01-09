<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class blogs_has_approval extends Model
{
    protected $table = 'blogs_has_approval';
    public $timestamps = false;
    public function blogs()
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }
}
