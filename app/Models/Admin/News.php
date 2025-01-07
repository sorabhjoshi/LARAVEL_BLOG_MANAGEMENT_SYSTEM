<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';  // Ensure your table name is correct
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
        'language',
        'status'
    ];

    // Relationship to the Newscat model
    public function category()
    {
        return $this->belongsTo(Newscat::class, 'category', 'id');
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
}
