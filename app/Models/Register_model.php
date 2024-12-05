<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register_model extends Model
{
    protected $table = 'users';
    
    use HasFactory;
    protected $fillable = [
        'name',
        'gender',
        'email',
        'password',
        'city',
        'state',
        'phoneno',
        'country',
    ];

}
