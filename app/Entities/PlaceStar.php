<?php

namespace GottaShit\Entities;

use Illuminate\Database\Eloquent\Model;

class PlaceStar extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'place_stars';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'place_id', 'stars'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * One Star belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('GottaShit\Entities\User');
    }

    /**
     * One Star belongs to Place.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo('GottaShit\Entities\Place');
    }
}
