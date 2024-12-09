<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companydata extends Model
{
    protected $table = 'companydata';
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'email'
    ];
}
