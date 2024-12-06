<?php

namespace App\Models;
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
}
