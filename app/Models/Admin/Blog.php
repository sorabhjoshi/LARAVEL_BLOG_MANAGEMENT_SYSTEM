<?php

namespace App\Models\Admin;
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

    public static function getBlogCategories()
    {
        return self::selectRaw('TRIM(LOWER(category)) AS category, COUNT(*) AS count')
            ->groupByRaw('TRIM(LOWER(category))')
            ->orderBy('category')
            ->get();
    }
}
