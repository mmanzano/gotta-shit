<?php

namespace App\Providers;

use App\Entities\Place;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('distinct_place_store', function ($attribute, $value, $parameters, $validator) {
            $latitude = $value;
            $longitude = $validator->getData()['geo_lng'];
            $totalLat = 180;
            $totalLng = 360;
            $radius = 6371000;
            $pi = pi();
            $totalMeters = 2 * $pi * $radius;

            $deltaLat = ($totalLat * 10) / ($totalMeters / 2);
            $deltaLng = ($totalLng * 10) / ($totalMeters);

            $places = Place::whereBetween('geo_lat', [$latitude - $deltaLat, $latitude + $deltaLat])
                ->whereBetween('geo_lng', [$longitude - $deltaLng, $longitude + $deltaLng])
                ->paginate(8);

            return $places->count() == 0;
        });

        Validator::extend('distinct_place_update', function ($attribute, $value, $parameters, $validator) {
            $latitude = $value;
            $longitude = $validator->getData()['geo_lng'];
            $totalLat = 180;
            $totalLng = 360;
            $radius = 6371000;
            $pi = pi();
            $totalMeters = 2 * $pi * $radius;

            $deltaLat = ($totalLat * 10) / ($totalMeters / 2);
            $deltaLng = ($totalLng * 10) / ($totalMeters);

            $places = Place::whereBetween('geo_lat', [$latitude - $deltaLat, $latitude + $deltaLat])
                ->whereBetween('geo_lng', [$longitude - $deltaLng, $longitude + $deltaLng])
                ->paginate(8);

            return $places->count() <= 1;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
