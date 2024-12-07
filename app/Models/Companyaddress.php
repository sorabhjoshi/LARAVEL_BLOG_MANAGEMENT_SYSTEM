<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companyaddress extends Model
{
    protected $table = 'companyaddress';
    use HasFactory;

    protected $fillable = [
        'companyid',
        'address',
        'latitude',
        'longitude',
        'mobile'
    ];
}
