<?php

namespace godforhire\Toast;

use Illuminate\Support\ServiceProvider;

class ToastServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'godforhire\Toast\SessionStore',
            'godforhire\Toast\LaravelSessionStore'
        );

        $this->app->singleton('toast', function () {
            return $this->app->make('godforhire\Toast\ToastNotifier');
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'toast');

        $this->publishes([
            __DIR__ . '/../views' => base_path('resources/views/vendor/toast')
        ]);
    }

}