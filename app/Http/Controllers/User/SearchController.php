<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProfileService;
use Carbon\Carbon;

class SearchController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @var ProfileService
     */    
    protected $service;

    public function __construct(
        ProfileService $service
    )
    {
        $this->service = $service;
    }

    public function saveSearchCondition()
    {
        \DB::beginTransaction();

        try {
            $params = request()->except(['_token']);
            
            if (isset($params['prefs'])) $params['prefs'] = json_encode($params['prefs']);
            if (isset($params['room_ids'])) $params['room_ids'] = json_encode($params['room_ids']);

            auth('api')->user()->searches()->create($params);

            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollBack();

            return response()->json(['status' => 'failed']);
        }

        return response()->json(['status' => 'success', 'searches' => auth('api')->user()->searches]);
    }

    public function deleteSearch()
    {
        auth('api')->user()->searches()->find(request()->get('id'))->delete();
        
        return response()->json(['status' => 'success', 'searches' => auth('api')->user()->searches]);
    }

    public function search()
    {
        $params = request()->except(['_token']);

        $query = \App\Models\Party::query();

        $query->where('open_date', '>=', Carbon::now()->format('Y-m-d'))
            ->where('open_date', '<=', Carbon::now()->addDay(7)->format('Y-m-d')) 
            ->with('room');

        $gender = $params['gender'];
        $myAge = $params['your_age'] ?? null;
        if (auth('api')->check()) {
            $gender = auth('api')->user()->profile->gender;
            $myAge = auth('api')->user()->profile->age;
        }

        $highColumnName = "{$gender}_high_age";
        $lowColumnName = "{$gender}_low_age";
        if (isset($myAge)) {
            $query->where(function ($query) use ($myAge, $highColumnName, $lowColumnName) {
                return $query->where($highColumnName, '>', $myAge)
                            ->where($lowColumnName, '<', $myAge);
            });
        }

        $highColumnName = $gender == 'male' ? "female_high_age" : "male_high_age";
        $lowColumnName = $gender == 'male' ? "female_low_age" : "male_low_age";
        // お相手の年齢
        if (isset($params['age_from']) && $params['age_from'] != '') {
            $value = $params['age_from'];
            $query->where(function ($query) use ($value, $highColumnName, $lowColumnName) {
                return $query->where($highColumnName, '>', $value)
                            ->orWhere($lowColumnName, '>', $value);
            });
        }
        
        if (isset($params['age_to']) && $params['age_to'] != '') {
            $value = $params['age_to'];
            $query->where(function ($query) use ($value, $highColumnName, $lowColumnName) {
                return $query->where(function ($query) use ($value, $highColumnName, $lowColumnName) {
                    return $query->where($highColumnName, '>', $value);
                })->orWhere(function ($query) use ($value, $highColumnName, $lowColumnName) {
                    return $query->where($highColumnName, '<=', $value)
                            ->where($lowColumnName, '<', $value);
                });
            });
        }

        // エリア
        if (isset($params['areas']) && sizeof($params['areas']) > 0) {
            // $prefs = explode(",", $params['prefs']);
            $prefs = $params['areas'];
            $query->whereHas('room', function ($query) use ($prefs) {
                foreach ($prefs as $pref) {
                    $query->orWhere('address', 'like', "%{$pref}%");
                }
            });
        }
        
        // フリーワード
        if (isset($params['keyword']) && $params['keyword'] != '') {
            $keyword = $params['keyword'];
            $query->where(function ($query) use ($keyword) {
                return $query->where('title', 'like', "%{$keyword}%")
                            ->orWhere('content', 'like', "%{$keyword}%")
                            ->orWhere('flows', 'like', "%{$keyword}%");
            });
        }

        // // 年齢重視で選ぶ


        // 価値観重視で選ぶ
        if (isset($params['value_sense']) && $params['value_sense'] != '') {
            $query->where('value_sense', $params['value_sense']);
        }

        if (isset($params['room_ids']) && sizeof($params['room_ids']) > 0) {
            $query->whereHas('room', function ($query) use ($params) {
                return $query->whereIn('id', $params['room_ids']);
            });
        }

        // 日付
        if (isset($params['open_at']) && $params['open_at'] != '') {
            $query->where('open_date', 'like', "%{$params['open_at']}%");
        }
        
        // 開始時間
        if (isset($params['open_time']) && $params['open_time'] != '') {
            $query->where('open_time', '>=', $params['open_time']);
        }

        return response()->json(['parties' => $query->get()]);
    }
}
