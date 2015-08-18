<?php

namespace GottaShit\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth as Auth;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongTo
     */
    public function user()
    {
        return $this->belongsTo('GottaShit\Entities\User');
    }

    /**
     * A Subscription belongs to Place.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongTo
     */
    public function place()
    {
        return $this->belongsTo('GottaShit\Entities\Place');
    }

}
