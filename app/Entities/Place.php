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
    public function stars()
    {
        return $this->hasMany('ShitGuide\Entities\PlaceStar');
    }

    /**
     * One Place has many Comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('ShitGuide\Entities\PlaceComment');
    }

    public function getStarAttribute()
    {
        $starsForPlace = $this->stars()->getResults();

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

        return number_format($starAverage, 2);
    }

    public function getStarWidthAttribute(){
        $starAverage = $this->getStarAttribute();
        if($starAverage == 0)
            $starWidth = '0%';
        else
            $starWidth = number_format(($starAverage / 5) * 100, 0) . '%';
        return $starWidth;
    }
    public function getNumberOfCommentsAttribute()
    {
        $allComments = $this->comments()->getResults();

        $countComments = 0;

        foreach($allComments as $comments)
        {
            $countComments++;
        }

        return $countComments;

    }

}
