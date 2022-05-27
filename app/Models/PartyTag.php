<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyTag extends Model
{
    protected $fillable = [
        'party_id',
        'tag_id'
    ];
}
