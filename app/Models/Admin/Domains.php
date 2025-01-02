<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domains extends Model
{
    use HasFactory;

    protected $fillable = [
        'domainname',
        'companyname',
        'mail_header',
        'mail_footer',
        'server_address',
        'port',
        'authentication',
        'username',
        'password',
        'tomail_id',
    ];
}
