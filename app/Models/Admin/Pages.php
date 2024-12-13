<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $table = 'pages';
    use HasFactory;

    protected $fillable = [
        'author',
        'userid',
        'slug',
        'title',
        'description'
    ];
}
