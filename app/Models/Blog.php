<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    use HasFactory;

    protected $fillable = [
        'authorname',
        'userid',
        'slug',
        'title',
        'image',
        'description',
        'category',
    ];
}
