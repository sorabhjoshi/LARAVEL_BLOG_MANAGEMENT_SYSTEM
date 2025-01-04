<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = 'designation';
    public function departments()
    {
        return $this->belongsTo(department::class, 'department_id', 'id');
    }
}
