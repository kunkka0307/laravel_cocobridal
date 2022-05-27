<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

    protected $fillable = [
        'user_id',
        'avatar',
        'firstname',
        'lastname',
        'furi_firstname',
        'furi_lastname',
        'gender',
        'birthday',
        'phone',
        'pref',
        'comment',
        'job',
        'height',
        'income',
        'holiday',
        'hobby',
        'dwelling',
        'drink',
        'smoking',
        'cooking',
        'best_cooking',
        'birthplace',
        'bloodtype',
        'family',
        'marriage_history',
        'email',
        'password'
    ];

    protected $table = 'profiles';

    protected $casts = [
        'birthday' => 'date'
    ];

    protected $appends = [
        'gender_label',
        'birthday_label',
        'avatar_url',
        'job_label',
        'income_label',
        'holiday_label',
        'hobby_label',
        'dwelling_label',
        'drink_label',
        'smoking_label',
        'cooking_label',
        'birthplace_label',
        'bloodtype_label',
        'family_label',
        'marriage_history_label',
        'age'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getGenderLabelAttribute()
    {
        return $this->gender == 'male' ? '男性' : '女性';
    }
    
    public function getBirthdayLabelAttribute()
    {
        return isset($this->birthday) ? $this->birthday->format('Y-m-d') : '---';
    }

    public function getJobLabelAttribute()
    {
        try {
            return config('values.jobs')[$this->job];
        } catch (\Throwable $e) {}

        return "";
    }
    
    public function getIncomeLabelAttribute()
    {
        try {
            return config('values.incomes')[$this->income];
        } catch (\Throwable $e) {}

        return "";
    }
    
    public function getHolidayLabelAttribute()
    {
        try {
            return config('values.holidays')[$this->holiday];
        } catch (\Throwable $e) {}

        return "";
    }
    
    public function getDwellingLabelAttribute()
    {
        try {
            return config('values.dwellings')[$this->dwelling];
        } catch (\Throwable $e) {}

        return "";
    }
    
    public function getDrinkLabelAttribute()
    {
        try {
            return config('values.drinks')[$this->drink];
        } catch (\Throwable $e) {}

        return "";
    }
    
    public function getSmokingLabelAttribute()
    {
        try {
            return config('values.smokings')[$this->smoking];
        } catch (\Throwable $e) {}

        return "";
    }
    
    public function getCookingLabelAttribute()
    {
        try {
            return config('values.cookings')[$this->cooking];
        } catch (\Throwable $e) {}

        return "";
    }
    
    public function getBirthplaceLabelAttribute()
    {
        try {
            return config('values.birthplaces')[$this->birthplace];
        } catch (\Throwable $e) {}

        return "";
    }
    
    public function getBloodtypeLabelAttribute()
    {
        try {
            return config('values.bloodtypes')[$this->bloodtype];
        } catch (\Throwable $e) {}

        return "";
    }
    
    public function getFamilyLabelAttribute()
    {
        try {
            return config('values.familys')[$this->family];
        } catch (\Throwable $e) {}

        return "";
    }
    
    public function getMarriageHistoryLabelAttribute()
    {
        try {
            return config('values.marriage_historys')[$this->marriage_history];
        } catch (\Throwable $e) {}

        return "";
    }

    public function getAvatarUrlAttribute()
    {
        if (isset($this->avatar)) {
            $parseUrl = parse_url($this->avatar);
            if (isset($parseUrl['host'])) {
                return $this->avatar;
            }

            return Storage::disk('public')->url($this->avatar);
        }

        return "https://www.gravatar.com/avatar/f2c97b1f2d2898cd2d6466ce95d4ba33.jpg?s=200&d=mp";
    }

    public function getHobbyLabelAttribute()
    {
        if (isset($this->hobby)) {
            $res = array();
            $hobby = json_decode($this->hobby);
            foreach ($hobby as $value) {
                $res[] = config('values.hobbys')[$value];
            }

            return implode("、", $res);
        }

        return '';
    }

    public function getAgeAttribute()
    {
        if (isset($this->birthday)) {
            return $this->birthday->age;
        }

        return 0;
    }
}
