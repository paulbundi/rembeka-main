<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MpesaBalance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'mpesa_c2b', 'mpesa_b2c',
    ];
}
