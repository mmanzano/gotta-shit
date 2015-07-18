<?php

namespace ShitGuide\Entities;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
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
    protected $fillable = ['name', 'geo_lat', 'geo_lng'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * One Place has many Stars.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Stars()
    {
        return $this->hasMany('Star');
    }

    /**
     * One Place has many Comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Comments()
    {
        return $this->hasMany('Comment');
    }

    public function getStarAttribute()
    {
        $starsForPlace = PlaceStar::where('place_id', $this->id)->get();

        $totalStar = 0;
        $count = 0;
        $starAverage = 0;

        foreach($starsForPlace as $star)
        {
            $totalStar += $star->stars;
            $count++;
        }

        if ($count != 0)
        {
            $starAverage = $totalStar / $count;
        }

        return $starAverage;
    }

    public function getCommentAttribute()
    {
        return PlaceComment::where('place_id', $this->id)->get();
    }
}
