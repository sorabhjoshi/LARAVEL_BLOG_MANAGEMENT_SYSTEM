<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    protected $table = 'department';
    public function designation()
    {
        return $this->hasMany(Designation::class, 'department_id', 'id');
    }
}
