<?php

namespace GottaShit\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'place_id', 'comment_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    /**
     * A Subscription belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A Subscription belongs to Place.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
