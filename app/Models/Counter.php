<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Counter extends Authenticatable
{
    use HasFactory;

    protected $guarded = [];

}
