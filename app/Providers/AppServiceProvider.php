<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Plan;
use App\Models\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 全てのメソッドが呼ばれる前に呼ばれるメソッド。
        view()->composer('*', function ($view) {
            // get the current user
            $user = \Auth::user();
            // インスタンス化
            $planModel = new Plan();
            $plans = $planModel->myPlan(\Auth::id());

            // タグに取得
            $tagModel = new Tag();
            $tags = $tagModel->where('user_id', \Auth::id())->get();

            //ビューに渡す
            $view->with('user', $user)->with('plans', $plans)->with('tags', $tags);
        });
    }
}
