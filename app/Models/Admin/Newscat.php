<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newscat extends Model
{
    protected $table = 'newscategory';
    use HasFactory;

    protected $fillable = [
        'categorytitle',
        'seotitle',
        'metakeywords',
        'metadescription'
    ];
    public function news()
    {
        return $this->hasMany(News::class, 'category', 'id');
    }
}
