<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public function myPlan($user_id)
    {
        $tag = \Request::query('tag');
        // タグがなければ、その人が持っているメモを全て取得
        if (empty($tag)) {
            return $this::select('plans.*')->where('user_id', $user_id)->where('status', 1)->get();
        } else {
            // もしタグの指定があればタグで絞る ->wher(tagがクエリパラメーターで取得したものに一致)
            $plans = $this::select('plans.*')
                ->leftJoin('tags', 'tags.id', '=', 'plans.tag_id')
                ->where('tags.name', $tag)
                ->where('tags.user_id', $user_id)
                ->where('plans.user_id', $user_id)
                ->where('status', 1)
                ->get();
            return $plans;
        }
    }
}
