<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Model & Observer mapping.
     *
     * @var array
     */
    private $observers = [
        \App\Models\User::class => \App\Models\Observers\UserObserver::class,
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->observers as $model => $observer) {
            call_user_func_array([$model, 'observe'], [$observer]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
