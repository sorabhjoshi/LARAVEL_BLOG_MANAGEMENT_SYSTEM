<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permissions extends Model
{
    protected $table = 'permissions';
    use HasFactory;
    protected $fillable = ['name', 'module_id', 'guard_name'];
}
