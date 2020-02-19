<?php

function reverse_geocode($lat = 0, $lng = 0)
{
    $key = env("MAP_KEY");
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&key=$key";

    $geodata = @file_get_contents($url);

    return reverse_geocode_data($geodata,$lat,$lng);
}




//reverse geocode raw data
function reverse_geocode_data($data,$lat=0,$lng=0)
{
    $data = @json_decode($data, 1);

    $_locale = ["lat"=>$lat,"lng"=>$lng,"city" => "", "state" => "", "country" => "", "success" => false];

    if (!isset($data['status']) || $data['status'] != "OK") {
        return $_locale;
    }

    foreach ($data['results'] as $localities) {

        foreach ($localities as $locality) {
          if(is_array($locality)) {
            foreach ($locality as $key => $locale) {

                if (isset($locale['types'])) {
                    $types = $locale['types'];

                    if ($types[0] == "locality") {
                        $_locale['city'] = $locale['long_name'];
                    }

                    if ($types[0] == "administrative_area_level_1") {
                        $_locale['state'] = $locale['long_name'];
                    }

                    if ($types[0] == "country") {
                        $_locale['country'] = $locale['long_name'];
                    }

                }
            }
          }
        }

    }

    $_locale['success'] = true;

    return $_locale;
}

function fetch_way_points($url)
{
    $geodata = @file_get_contents($url);
    //$geodata = file_get_contents(BASE_PATH."/app/data/waypoints.json");

    $geodata = json_decode($geodata, 1);

    $osteps = [];
    if (isset($geodata['routes'][0]['legs'][0]['steps'])) {
        foreach ($geodata['routes'][0]['legs'][0]['steps'] as $st) {
            $osteps[] = $st['end_location'];
        }
    }

    return $osteps;
}

//find distance between 2 points
function find_matrix($lat1, $lon1, $lat2, $lon2)
{

    $miles = distance($lat1, $lon1, $lat2, $lon2, 'M');
    $kilo  = distance($lat1, $lon1, $lat2, $lon2, 'K');

    return ['m' => $miles, 'k' => $kilo];
}

/**
 * Calculates the great-circle distance between two points, with
 * the Haversine formula.
 * @param float $latitudeFrom Latitude of start point in [deg decimal]
 * @param float $longitudeFrom Longitude of start point in [deg decimal]
 * @param float $latitudeTo Latitude of target point in [deg decimal]
 * @param float $longitudeTo Longitude of target point in [deg decimal]
 * @param float $earthRadius Mean earth radius in [m]
 * @return float Distance between points in [m] (same as earthRadius)
 */
function haversineGreatCircleDistance(
    $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo   = deg2rad($latitudeTo);
    $lonTo   = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
}

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/*::                                                                         :*/
/*::  This routine calculates the distance between two points (given the     :*/
/*::  latitude/longitude of those points). It is being used to calculate     :*/
/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
/*::                                                                         :*/
/*::  Definitions:                                                           :*/
/*::    South latitudes are negative, east longitudes are positive           :*/
/*::                                                                         :*/
/*::  Passed to function:                                                    :*/
/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
/*::    unit = the unit you desire for results                               :*/
/*::           where: 'M' is statute miles (default)                         :*/
/*::                  'K' is kilometers                                      :*/
/*::                  'N' is nautical miles                                  :*/
/*::  Worldwide cities and other features databases with latitude longitude  :*/
/*::  are available at https://www.geodatasource.com                          :*/
/*::                                                                         :*/
/*::  For enquiries, please contact sales@geodatasource.com                  :*/
/*::                                                                         :*/
/*::  Official Web site: https://www.geodatasource.com                        :*/
/*::                                                                         :*/
/*::         GeoDataSource.com (C) All Rights Reserved 2018                  :*/
/*::                                                                         :*/
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return round(0, 2);
    } else {
        $theta = $lon1 - $lon2;
        $dist  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist  = acos($dist);
        $dist  = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit  = strtoupper($unit);

        if ($unit == "K") {
            return round(($miles * 1.609344), 2);
        } else if ($unit == "N") {
            return round(($miles * 0.8684), 2);
        } else {
            return round($miles, 2);
        }
    }
}

/*
echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";
 */
