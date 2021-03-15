<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth as Auth;

class PlaceComment extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @var string */
    protected $table = 'place_comments';

    /** @var array */
    protected $fillable = ['user_id', 'place_id', 'comment'];

    /** @var array */
    protected $hidden = [];

    /** @var array */
    protected $dates = ['deleted_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    public function getPathAttribute(): string
    {
        return $this->place->path . '#comment-' . $this->id;
    }

    public function getIsAuthorAttribute(): bool
    {
        return Auth::id() == $this->user_id;
    }

    public function getPublicationDateAttribute(): string
    {
        return $this->created_at->diffInDays() >= 1
            ? ucfirst($this->created_at->formatLocalized('%A %d %B %Y %H:%M'))
            : $this->created_at->diffForHumans();
    }
}
