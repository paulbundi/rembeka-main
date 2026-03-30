<?php

namespace App\Models;

use App\traits\ScopedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory, ScopedFilter;

    protected $fillable = [

        'user_id', 'name', 'lat', 'long', 'appartment', 'floor', 'room',
    ];
}
