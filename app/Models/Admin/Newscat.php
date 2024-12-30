<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newscat extends Model
{
    protected $table = 'newscategory';  // Ensure your table name is correct
    use HasFactory;

    protected $fillable = [
        'categorytitle',
        'seotitle',
        'metakeywords',
        'metadescription'
    ];

    // Relationship to the News model
    public function news()
    {
        return $this->hasMany(News::class, 'category', 'id');
    }
}
