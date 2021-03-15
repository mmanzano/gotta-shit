<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceStar extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @var string */
    protected $table = 'place_stars';

    /** @var array */
    protected $fillable = ['user_id', 'place_id', 'stars'];

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
}
