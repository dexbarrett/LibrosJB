<?php

namespace LibrosJB\Providers;

use LibrosJB\BookFormat;
use LibrosJB\BookLanguage;
use LibrosJB\BookCondition;
use Illuminate\Support\Facades\Auth;
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
        view()->composer(['admin.create-book', 'admin.edit-book'], function ($view) {
            $view->with('bookConditions', BookCondition::all()->lists('name', 'id'));
            $view->with('bookLanguages', BookLanguage::all()->lists('name', 'id'));
            $view->with('bookFormats', BookFormat::all()->lists('name', 'id'));
        });

        view()->composer(['partials.admin-dropdown', 'partials.user-dropdown'], function($view) {
            $messageManager = $this->app->make('LibrosJB\MessageManager');

            $view->with(
                'totalUnreadMessages',
                 $messageManager->getTotalUnreadMessagesForUser(Auth::user()->id)
            );
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
