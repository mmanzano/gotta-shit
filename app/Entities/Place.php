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
    protected $fillable = ['name', 'geo_lat', 'geo_lng', 'user_id'];

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

    public function starForPlace()
    {
        $starsForPlace = $this->stars()->getResults();

        $starResult = array(
          'votes' => 0,
          'totalStar' => 0,
          'average' => 0,
          'width' => '0%',
        );

        foreach($starsForPlace as $star)
        {
            $starResult['votes']++;
            $starResult['totalStar'] += $star->stars;
        }

        if ($starResult['votes'] != 0)
        {
            $starResult['average'] = number_format($starResult['totalStar'] / $starResult['votes'], 2);
            $starResult['width'] = number_format(($starResult['average'] / 5) * 100, 0) . '%';
        }

        return $starResult;
    }

    public function starForUser()
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
