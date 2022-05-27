<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $table = 'searches';

    protected $fillable = [
        'user_id',
        'gender',
        'your_age',
        'age_from',
        'age_to',
        'prefs',
        'open_at',
        'open_time',
        'keyword',
        'age_range',
        'value_sense',
        'room_ids',
    ];

    protected $appends = [
        'prefs_label',
        'age_label'
    ];

    public function getPrefsLabelAttribute()
    {
        if (isset($this->prefs)) {
            return json_decode($this->prefs) == '指定されていません' ? "" : json_decode($this->prefs);
        }

        return "";
    }

    public function getAgeLabelAttribute()
    {
        $value = "";
        if (isset($this->age_from)) $value = "{$this->age_from}歳 ~ ";
        if (isset($this->age_to)) {
            if ($value == "") 
                $value = " ~ {$this->age_to}歳";
            else
                $value = "{$value} {$this->age_to}歳";
        }

        return $value;
    }
}
