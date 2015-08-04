<?php

namespace GottaShit\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use SoftDeletes;
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

    protected $dates = ['deleted_at'];
    /**
     * One Place has one User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('GottaShit\Entities\User');
    }

    /**
     * One Place has many Stars.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stars()
    {
        return $this->hasMany('GottaShit\Entities\PlaceStar');
    }

    /**
     * One Place has many Comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('GottaShit\Entities\PlaceComment');
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

    public function StarForUser()
    {
        $starsForPlace = $this->stars()->getResults();

        $stars = array(
            'id' => 0,
            'stars' => 0,
        );

        foreach($starsForPlace as $star)
        {
            if ($star->user->id == \Auth::User()->id)
            {
                $stars = array(
                    'id' => $star->id,
                    'stars' =>  number_format($star->stars, 0),
                );
            }
        }

        return $stars;
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

    public function getIsAuthorAttribute()
    {
        $isAuthor = false;
        
        if(\Auth::check()){
            if (\Auth::User()->id == $this->user_id)
            {
                $isAuthor = true;
            }
        }
        return $isAuthor;

    }
}
