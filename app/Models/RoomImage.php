<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    protected $fillable = [
        'room_id',
        'image',
    ];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute()
    {
        if (isset($this->image)) {
            $parseUrl = parse_url($this->image);
            if (isset($parseUrl['host'])) {
                return $this->image;
            }

            return "/{$this->image}";
        }

        return "/images/no-image.png";
    }
}