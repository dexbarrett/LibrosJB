<?php

namespace LibrosJB;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'facebook_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'facebook_id'];

    public function settings()
    {
        return $this->hasOne(UserSettings::class);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function isAdmin()
    {
        return (bool)$this->attributes['admin'] === true;
    }

    public function setRandomPasswordIfNotPresent()
    {
        if (is_null($this->password)) {
            $this->password = str_random(20);
        }
    }

    public function initializeSettings()
    {
        if ($this->settings) {
            return;
        }

        $userSettings = new UserSettings;
        $userSettings->email_notifications = true;
        
        $this->settings()->save($userSettings);
    }

    public function hasEmailNotificationsEnabled()
    {
        return (bool)$this->settings->email_notifications === true;
    }
}
