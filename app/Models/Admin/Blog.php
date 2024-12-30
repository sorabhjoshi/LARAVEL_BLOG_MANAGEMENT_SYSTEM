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
        'user_id',
        'slug',
        'title',
        'image',
        'description',
        'category',
    ];
   public function category()
{
    return $this->belongsTo(Blogcat::class, 'category', 'id');
}

    public static function getBlogCategories()
    {
        return self::selectRaw('TRIM(LOWER(category)) AS category, COUNT(*) AS count')
            ->groupByRaw('TRIM(LOWER(category))')
            ->orderBy('category')
            ->get();
    }
}
