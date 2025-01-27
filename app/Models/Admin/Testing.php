<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testing extends Model
{
    use HasFactory;

    protected $table = 'testing';

    protected $fillable = [
        'id',
        'name'
    ];
    

    public $timestamps = false;

}
