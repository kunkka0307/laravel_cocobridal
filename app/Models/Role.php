<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ADMINISTRATOR = 'administrator';
    const User = 'user';

    protected $fillable = [
        'name',
    ];
}
