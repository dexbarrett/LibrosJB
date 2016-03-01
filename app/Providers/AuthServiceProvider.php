<?php

namespace LibrosJB\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'LibrosJB\Model' => 'LibrosJB\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        $gate->define('view-conversation', function ($user, $conversation) {
            return $user->id === $conversation->from_user || $user->id === $conversation->to_user;
        });

        $gate->define('create-conversation', function ($user, $book) {
            return $user->id !== $book->user_id;
        });

        $gate->define('create-message', function ($user, $conversation, $recipientID) {
            return ($user->id === $conversation->from_user || $user->id === $conversation->to_user) && 
            $user->id !== $recipientID;
        });

        $gate->define('manage-book', function ($user, $book) {
            return $user->id === $book->user_id;
        });

        $gate->define('manage-photos', function ($user, $book) {
            return $user->id === $book->user_id;
        });
    }
}
