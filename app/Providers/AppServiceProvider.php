<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Job;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);

        View::composer('frontend.include.app', function ($view) {
            $user = Auth::user();
            $jobs = Job::all();
            $events = Event::with('job')->get();

            $view->with('user', $user)
                ->with('jobs', $jobs)
                ->with('events', $events);
        });
    }
}
