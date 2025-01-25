<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogList extends Model
{
    use HasFactory;

    protected $table = 'companydata';

    protected $fillable = [
        'id',
        'name',
        'email'
    ];
}
