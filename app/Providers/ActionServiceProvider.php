<?php

namespace App\Providers;

use App\Actions\ActionBus;
use App\Actions\ActionHandlers\AddProjectActionHandler;
use App\Actions\AddProjectAction;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    protected $actionBindings = [
        AddProjectAction::class => AddProjectActionHandler::class
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ActionBus::class, function () {
            return new ActionBus($this->app, $this->actionBindings);
        });
    }
}
