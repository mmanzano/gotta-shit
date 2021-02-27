<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /** @var string */
    protected $table = 'users';

    /** @var array */
    protected $fillable = [
        'full_name',
        'username',
        'email',
        'verified',
        'modified',
        'token',
        'password',
        'language',
        'github_id',
        'facebook_id',
        'twitter_id',
        'avatar',
    ];

    /** @var array */
    protected $hidden = ['password', 'remember_token'];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($user) {
            $user->token = Str::random(30);
        });
    }

    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }

    public function placesTrashed(): HasMany
    {
        return $this->places()->onlyTrashed();
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

    public function getPathAttribute(): string
    {
        return route('user.show', ['user' => $this->id]);
    }

    public function getNumberOfPlacesAttribute(): int
    {
        return $this->places()->count();
    }

    public function getNumberOfRatedPlacesAttribute(): int
    {
        return $this->stars()->count();
    }

    public function getNumberOfTrashedPlacesAttribute(): int
    {
        return $this->placesTrashed()->count();
    }

    public function confirmEmail(): bool
    {
        return $this->update([
            'verified' => true,
            'modified' => false,
            'token' => null,
        ]);
    }

    public function setLanguage($language): bool
    {
        return $this->update([
            'language' => $language,
        ]);
    }

    public function updateOrCreateSubscription(Place $place)
    {
        return $this->subscriptions()->updateOrCreate([
            'place_id' => $place->id,
        ], ['comment_id' => null]);
    }

    public function updateSubscription(Place $place)
    {
        return $this->subscriptions()
            ->where('place_id', $place->id)
            ->update(['comment_id' => null]);
    }

    public function deleteSubscription(Place $place)
    {
        return $this->subscriptions()
            ->where('place_id', $place->id)
            ->forceDelete();
    }
}
