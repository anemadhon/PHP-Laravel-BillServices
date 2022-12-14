<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';
    protected $guarded = [];
    protected $casts = ['id' => 'string'];

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
