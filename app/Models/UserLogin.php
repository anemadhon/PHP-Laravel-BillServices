<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use HasFactory;

    public $incrementing = false;

    const CREATED_AT = 'login_date';
    const UPDATED_AT = 'logout_date';
    
    protected $keyType = 'string';
    protected $guarded = [];
    protected $cast = [
        'id' => 'string',
        'is_login' => 'boolean'
    ];
}