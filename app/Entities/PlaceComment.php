<?php

namespace GottaShit\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth as Auth;

class PlaceComment extends Model
{
    use SoftDeletes;

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

    protected $dates = ['deleted_at'];

    /**
     * A Comment belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('GottaShit\Entities\User');
    }

    /**
     * A Comment belongs to Place.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo('GottaShit\Entities\Place');
    }

    public function getIsAuthorAttribute()
    {
        return Auth::id() == $this->user_id;
    }

    public function getPublicationDateAttribute()
    {
        if ($this->created_at->diffInDays() >= 1) {
            return ucfirst($this->created_at->formatLocalized('%A %d %B %Y %H:%M'));
        } else {
            return $this->created_at->diffForHumans();
        }
    }
}
