<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $fillable = [
        'title',
        'lat',
        'lang',
        'comment',
        'address',
        'access',
        'zipcode'
    ];

    protected $appends = [
        'thumb'
    ];

    public function images()
    {
        return $this->hasMany(RoomImage::class, 'room_id');
    }

    public function getThumbAttribute()
    {
        if (sizeof($this->images)) return $this->images()->first()->image_url;

        return null;
    }
}
