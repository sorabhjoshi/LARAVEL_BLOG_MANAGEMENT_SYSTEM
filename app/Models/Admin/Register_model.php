<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Register_model extends Authenticatable
{
    use HasFactory;

    protected $table = 'users'; // Specify your table name if different

    protected $fillable = [
        'name',
        'gender',
        'email',
        'password',
        'city',
        'state',
        'country',
        'phoneno',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
