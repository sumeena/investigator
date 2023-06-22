<?php


use Illuminate\Support\Facades\Http;

if (!function_exists('getDistance')) {
    function getDistance($lat1, $lon1, $lat2, $lon2)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=" . $lat1 . "," . $lon1 . "&origins=" . $lat2 . "," . $lon2 . "&key=AIzaSyAB80hPTftX9xYXqy6_NcooDtW53kiIH3A&units=imperial";
//        dd($url);
        $response = Http::get($url);
        $data     = $response->json();

        // if status is not ok then return 0
        if ($data['status'] != 'OK') {
            return null;
        }

        // get distance value in number
        $distance = $data['rows'][0]['elements'][0]['distance']['value'];


        // convert distance to miles
        return $distance * 0.000621371;
    }
}
