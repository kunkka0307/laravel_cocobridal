<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyFlow extends Model
{
    protected $fillable = [
        'party_id',
        'title',
        'start_time',
        'sort',
        'comment'
    ];

    protected $table = 'party_flows';

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }
}
