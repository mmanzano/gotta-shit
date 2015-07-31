<?php

namespace GottaToShit\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth;

class PlaceComment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'place_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'place_id', 'comment'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * One Comment belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('GottaToShit\Entities\User');
    }

    /**
     * One Comment belongs to Place.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo('GottaToShit\Entities\Place');
    }

    public function getIsAuthorAttribute()
    {
        $isAuthor = false;
        if (\Auth::Check()) {
            if ($this->user_id == \Auth::User()->id) {
                $isAuthor = true;
            }
        }
        return $isAuthor;
    }
}
