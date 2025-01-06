<?php

namespace App\Models\admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    protected $table = 'department';
    public function designation()
    {
        return $this->hasMany(Designation::class, 'department_id', 'id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'department', 'id');
    }
}
