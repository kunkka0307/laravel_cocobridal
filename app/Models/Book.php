<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $fillable = [
        'user_id',
        'party_id',
        'status',
        'amount',
        'friend',
        'friend_info'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->with('profile');
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getBookIdAttribute()
    {
        return $this->id;
    }
}
