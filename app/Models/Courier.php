<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    protected $table = 'couriers';

    protected $fillable = [
        'name',
        'code',
        'phone',
        'email',
        'sim_number',
        'address',
        'level',
    ];
}
