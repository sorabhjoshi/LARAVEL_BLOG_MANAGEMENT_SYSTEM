<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityList extends Model
{
    use HasFactory;
    protected $table = 'tbl_cities';
    public $timestamps = false;
}