<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';
    protected $fillable = [
       'languages'
    ];
    public function languagename()
    {
        return $this->hasMany(Blog::class, 'language', 'id');
    }
}
