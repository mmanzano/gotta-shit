<?php

namespace GottaShit\Entities;

use GottaShit\Mailers\AppMailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth as Auth;

class Place extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'places';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'geo_lat', 'geo_lng', 'user_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    /**
     * A Place belongs to an User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('GottaShit\Entities\User');
    }

    /**
     * A Place has many Stars.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stars()
    {
        return $this->hasMany('GottaShit\Entities\PlaceStar');
    }

    /**
     * A Place has many Comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('GottaShit\Entities\PlaceComment');
    }

    /**
     * A Place has many Subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany('GottaShit\Entities\Subscription');
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($place) {
            $place->stars()->delete();
            $place->comments()->delete();
            $place->subscriptions()->delete();
        });

        static::restored(function ($place) {
            $place->stars()->withTrashed()->restore();
            $place->comments()->withTrashed()->restore();
            $place->subscriptions()->withTrashed()->restore();
        });
    }

    public function getStarsAmountAttribute()
    {
        return $this->starsWithTrashed()->count();
    }

    public function getStarsAverageAttribute()
    {
        $starsForPlace = $this->starsWithTrashed()->get();

        if ($starsForPlace->count() == 0) {
            return 0.00;
        }

        $average = $starsForPlace->sum('stars') / $starsForPlace->count();

        return number_format($average, 2);
    }

    public function getStarsProgressBarAttribute()
    {
        $starsForPlace = $this->starsWithTrashed()->get();

        if ($starsForPlace->count() == 0) {
            return '0%';
        }

        $average = $starsForPlace->sum('stars') / $starsForPlace->count();

        $averagePercent = ($average / 5) * 100;

        return number_format($averagePercent, 0) . '%';
    }

    public function getUserHasVotedAttribute()
    {
        return (bool)$this->starsWithTrashed()
                ->where('user_id', Auth::id())
                ->first()->id ?? false;
    }

    public function getIdOfUserStarAttribute()
    {
        return $this->starsWithTrashed()
                ->where('user_id', Auth::id())
                ->first()->id ?? false;
    }

    public function getCurrentUserVoteAttribute()
    {
        return number_format(
            $this->starsWithTrashed()
                ->where('user_id', Auth::id())
                ->first()
                ->stars ?? -1
        );
    }

    public function getNumberOfCommentsAttribute()
    {
        return $this->commentsWithTrashed()->count();
    }

    public function getIsAuthorAttribute()
    {
        return Auth::id() == $this->user_id;
    }

    public function starsWithTrashed()
    {
        if ($this->trashed()) {
            return $this->stars()->onlyTrashed();
        } else {
            return $this->stars();
        }
    }

    public function commentsWithTrashed()
    {
        if ($this->trashed()) {
            return $this->comments()->onlyTrashed();
        } else {
            return $this->comments();
        }
    }

    public function getAuthUserSubscriptionAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', Auth::id())
            ->first();
    }

    public function getIsSubscribedAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', Auth::id())
            ->exists();
    }
}
