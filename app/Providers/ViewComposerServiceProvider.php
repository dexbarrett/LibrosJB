<?php

namespace LibrosJB\Providers;

use LibrosJB\BookLanguage;
use LibrosJB\BookCondition;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['admin.create-book'], function ($view) {
            $view->with('bookConditions', BookCondition::all()->lists('name', 'id'));
            $view->with('bookLanguages', BookLanguage::all()->lists('name', 'id'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
