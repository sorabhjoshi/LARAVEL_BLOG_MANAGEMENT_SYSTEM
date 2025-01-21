<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';
    use HasFactory;

    protected $fillable = [
        'delete_status',
     ];
    public function permission()
    {
        return $this->hasMany(permissions::class);
    }
    public function childmodule()
    {
        return $this->hasMany(Module::class, 'parent_id');
    }
}

    