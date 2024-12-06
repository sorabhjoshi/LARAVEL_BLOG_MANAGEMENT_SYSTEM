<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogcat extends Model
{
    protected $table = 'blogcategory';
    use HasFactory;

    protected $fillable = [
        'categorytitle',
        'seotitle',
        'metakeywords',
        'metadescription'
    ];
}
