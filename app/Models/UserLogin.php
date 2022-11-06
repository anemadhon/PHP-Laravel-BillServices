<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $keyType = 'string';
    protected $guarded = [];
    protected $cast = [
        'id' => 'string',
        'is_login' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
