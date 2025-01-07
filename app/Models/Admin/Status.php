<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'status', 'id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'status', 'id');
    }
}
