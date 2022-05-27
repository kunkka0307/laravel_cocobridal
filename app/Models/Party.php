<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class Party extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $fillable = [
        'title',
        'eyecatch',
        'male_limit',
        'female_limit',
        'male_price',
        'female_price',
        'room_id',
        'content',
        'open_date',
        'open_time',
        'close_time',
        'male_high_age',
        'male_low_age',
        'female_high_age',
        'female_low_age',
        'value_sense',
        'flows',
        'created_at',
        'updated_at'
    ];

    protected $table = 'partys';

    protected $appends = [
        'eyecatch_url',
        'remaining_male_seat',
        'remaining_female_seat'
    ];

    public function room()
    {
        return $this->hasOne(\App\Models\Room::class, 'id', 'room_id');
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'party_id')->where('status', \App\Enums\BookStatus::RESERVED)->with('user');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, PartyTag::class, 'party_id','tag_id');
    }

    public function setEyecatchAttribute($value)
    {
        $attribute_name = "eyecatch";
        // or use your own disk, defined in config/filesystems.php
        $disk = config('backpack.base.root_disk_name'); 
        // destination path relative to the disk above
        $destination_path = "public/storage/uploads/party_photos"; 

        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value)->encode('jpg', 90);

            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';

            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            // 3. Delete the previous image, if there was one.
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it 
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;
        }
    }

    public function getFlowsLabelAttribute()
    {
        if (isset($this->flows)) {
            $flows = json_decode($this->flows);
            foreach ($flows as $flow) {
                return "{$flow->title}<br/>";
            }
        }

        return "";
    }

    public function getOpenAtAttribute()
    {
        if (isset($this->open_date) && isset($this->open_time)) {
            return \Carbon\Carbon::parse("{$this->open_date} {$this->open_time}");
        }

        return null;
    }

    public function getEyecatchUrlAttribute()
    {
        if (isset($this->eyecatch)) {
            $parseUrl = parse_url($this->eyecatch);
            if (isset($parseUrl['host'])) {
                return $this->eyecatch;
            }

            return "/{$this->eyecatch}";
        }

        return "/images/no-image.png";
    }

    public function getRemainingMaleSeatAttribute()
    {
        $maleBooksCount = $this->books()->whereHas('user', function ($query) {
            return $query->whereHas('profile', function ($query) {
                return $query->where('gender', 'male');
            });
        })->count();

        return $this->male_limit - $maleBooksCount;
    }
    
    public function getRemainingFemaleSeatAttribute()
    {
        $maleBooksCount = $this->books()->whereHas('user', function ($query) {
            return $query->whereHas('profile', function ($query) {
                return $query->where('gender', 'female');
            });
        })->count();

        return $this->male_limit - $maleBooksCount;
    }

    public function getBriefAttribute()
    {
        $openTime = \Carbon\Carbon::parse("{$this->open_date} {$this->open_time}")->format("Y年m月d日 H:i");
        $closeTime = \Carbon\Carbon::parse("{$this->open_date} {$this->close_time}")->format("H:i");

        return "{$this->title} ({$openTime} ~ {$closeTime})";
    }
}
