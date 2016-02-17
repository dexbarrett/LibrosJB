<?php

namespace LibrosJB;

use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    public function receiveEmailNotifications($value)
    {
        $this->email_notifications = $value;
        $this->save();
    }

    public function setEmailNotificationsAttribute($value)
    {
        if ($value === 'true') {
            $value = 1;
        } elseif ($value === 'false') {
            $value = 0;
        }

        $this->attributes['email_notifications'] = $value;
    }
}
