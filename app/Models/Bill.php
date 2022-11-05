<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    public $incrementing = false;

    protected $keyType = 'string';
    protected $guarded = [];
    protected $casts = ['id' => 'string'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
