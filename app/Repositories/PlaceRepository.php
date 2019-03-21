<?php
namespace GottaShit\Repositories;

use GottaShit\Entities\Place;
use Illuminate\Support\Facades\DB;

class PlaceRepository
{
    public function bestPlaces()
    {
        return Place::rightJoin('place_stars', 'place_stars.place_id', '=', 'places.id')
            ->select(DB::raw('places.*, sum(place_stars.stars)/count(place_stars.stars) AS star_average'))
            ->groupBy('places.id')
            ->orderBy('star_average', 'desc');
    }

    public function nearTo(float $latitude, float $longitude, int $distance)
    {
        $totalLat = 180;

        $totalLng = 360;

        $radius = 6371000;

        $pi = pi();

        $totalMeters = 2 * $pi * $radius;

        $deltaLat = ($totalLat * $distance) / ($totalMeters / 2);

        $deltaLng = ($totalLng * $distance) / ($totalMeters);

        return Place::whereBetween('geo_lat', [$latitude - $deltaLat, $latitude + $deltaLat])
            ->whereBetween('geo_lng', [$longitude - $deltaLng, $longitude + $deltaLng]);
    }
}
