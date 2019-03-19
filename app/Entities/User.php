<?php

namespace GottaShit\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
    protected $fillable = [
        'full_name',
        'username',
        'email',
        'password',
        'language',
        'github_id',
        'facebook_id',
        'twitter_id',
        'avatar'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->token = str_random(30);
        });
    }

    /**
     * An User has many Places.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function places()
    {
        return $this->hasMany('GottaShit\Entities\Place');
    }

    /**
     * An User has many Stars.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stars()
    {
        return $this->hasMany('GottaShit\Entities\PlaceStar');
    }

    /**
     * An User has many Comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('GottaShit\Entities\PlaceComment');
    }

    /**
     * An User has many Subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany('GottaShit\Entities\Subscription');
    }

    public function getNumberOfPlacesAttribute()
    {
        return $this->places()->count();
    }

    public function getNumberOfPlacesRatedAttribute()
    {
        return $this->stars()->count();
    }

    public function placesTrashed()
    {
        return $this->places()->onlyTrashed();
    }

    public function getNumberOfPlacesTrashedAttribute()
    {
        return $this->placesTrashed()->count();
    }

    /**
     * Confirm the user.
     *
     * @return void
     */
    public function confirmEmail()
    {
        $this->verified = true;
        $this->modified = false;
        $this->token = null;
        $this->save();
    }

    public function setLanguage($language)
    {
        $this->language = $language;
        $this->save();
    }
}
