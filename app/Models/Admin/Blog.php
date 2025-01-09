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
        'domain',
        'language'
    ];
    public static function getBlogCategories()
    {
        return self::selectRaw('TRIM(LOWER(category)) AS category, COUNT(*) AS count')
            ->groupByRaw('TRIM(LOWER(category))')
            ->orderBy('category')
            ->get();
    }
   public function category()
{
    return $this->belongsTo(Blogcat::class, 'category', 'id');
}
public function categories()
{
    return $this->belongsTo(Blogcat::class, 'category', 'id');
}


public function domainrel()
{
    return $this->belongsTo(Domains::class, 'domain', 'id');
}


public function langrel()
{
    return $this->belongsTo(Language::class, 'language', 'id');
}

public function statuss()
{
    return $this->belongsTo(Status::class, 'status', 'id');
}
public function approval()
{
    return $this->hasOne(blogs_has_approval::class, 'blog_id', 'id');
}
}
