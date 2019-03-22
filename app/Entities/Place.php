<?php

namespace GottaShit\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth as Auth;

class Place extends Model
{
    use SoftDeletes;

    /** @var string */
    protected $table = 'places';

    /** @var array */
    protected $fillable = ['name', 'geo_lat', 'geo_lng', 'user_id'];

    /** @var array */
    protected $hidden = [];

    /** @var array */
    protected $dates = ['deleted_at'];

    public static function boot(): void
    {
        parent::boot();

        static::created(function (Place $place) {
            if (request()->has('stars')) {
                PlaceStar::create([
                    'user_id' => $place->user_id,
                    'place_id' => $place->id,
                    'stars' => request('stars'),
                ]);
            }

            Subscription::create([
                'user_id' => $place->user_id,
                'place_id' => $place->id,
            ]);
        });

        static::updated(function (Place $place) {
            if (request()->has('stars')) {
                PlaceStar::updateOrCreate([
                    'place_id' => $place->id,
                    'user_id' => Auth::id(),
                ], ['stars' => request('stars')]);
            }
        });

        static::deleted(function (Place $place) {
            $place->stars()->delete();
            $place->comments()->delete();
            $place->subscriptions()->delete();
        });

        static::restored(function (Place $place) {
            $place->stars()->withTrashed()->restore();
            $place->comments()->withTrashed()->restore();
            $place->subscriptions()->withTrashed()->restore();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stars(): HasMany
    {
        return $this->hasMany(PlaceStar::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PlaceComment::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function getStarsAmountAttribute(): int
    {
        return $this->starsWithTrashed()->count();
    }

    public function getStarsAverageAttribute(): float
    {
        return number_format($this->starsWithTrashed()->avg('stars'), 2);
    }

    public function getStarsProgressBarAttribute(): string
    {
        $averagePercent = ($this->stars_average / 5) * 100;

        return number_format($averagePercent, 0) . '%';
    }

    public function getUserHasVotedAttribute(): bool
    {
        return $this->starsWithTrashed()
                ->where('user_id', Auth::id())
                ->first()->id ?? false;
    }

    public function getCurrentUserVoteAttribute(): int
    {
        return $this->starsWithTrashed()
                ->where('user_id', Auth::id())
                ->first()
                ->stars ?? -1;
    }

    public function getNumberOfCommentsAttribute(): int
    {
        return $this->commentsWithTrashed()->count();
    }

    public function getPathAttribute(): string
    {
        return route('place.show', ['place' => $this->id]);
    }

    public function getIsAuthorAttribute(): bool
    {
        return Auth::id() == $this->user_id;
    }

    public function getIsSubscribedAttribute(): bool
    {
        return $this->subscriptions()
            ->where('user_id', Auth::id())
            ->exists();
    }

    public function commentsWithTrashed(): HasMany
    {
        return $this->trashed()
            ? $this->comments()->onlyTrashed()
            : $this->comments();
    }

    private function starsWithTrashed(): HasMany
    {
        return $this->trashed()
            ? $this->stars()->onlyTrashed()
            : $this->stars();
    }
}
