<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryList extends Model
{
    use HasFactory;
    protected $table = 'tbl_countries';
    protected $fillable = [
        'name'
    ];
    
}