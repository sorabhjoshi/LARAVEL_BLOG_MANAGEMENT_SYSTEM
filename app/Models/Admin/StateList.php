<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateList extends Model
{
    use HasFactory;
    protected $table = 'tbl_states';  // Ensure your table name is correct
    protected $fillable = [
        'name', 'is_active', 'created_date', 'created_by', 'updated_date', 'updated_by'
    ];

    public $timestamps = false;
}