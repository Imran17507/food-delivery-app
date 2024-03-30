<?php

namespace App\Utilities;

class GeoDistanceCalculator {
    private $lat1;
    private $lon1;
    private $lat2;
    private $lon2;

    public function setCoordinates($lat1, $lon1, $lat2, $lon2): void
    {
        $this->lat1 = $lat1;
        $this->lon1 = $lon1;
        $this->lat2 = $lat2;
        $this->lon2 = $lon2;
    }

    private function deg2rad($deg)
    {
        return $deg * (M_PI / 180);
    }

    function getHaversineDistanceFromLatLonInKm() {
        $radiusOfEarthInKm = 6371;

        $dLat = $this->deg2rad($this->lat2 - $this->lat1);
        $dLon = $this->deg2rad($this->lon2 - $this->lon1);
        $squareOfHalfTheChordLength =
            sin($dLat / 2) * sin($dLat / 2) +
            cos($this->deg2rad($this->lat1)) * cos($this->deg2rad($this->lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $angularDistanceInRadius = 2 * atan2(sqrt($squareOfHalfTheChordLength), sqrt(1 - $squareOfHalfTheChordLength));

        $distanceInKm = $radiusOfEarthInKm * $angularDistanceInRadius;

        return $distanceInKm;
    }

    function getKeerthanaDistanceFromLatLonInKm() {
        $equatorialRadiusInKm = 6378.137;
        $polarRadiusInKm = 6356.752;

        $sq = function($x) { return $x * $x; };
        $sqr = function($x) { return sqrt($x); };
        $cos = function($x) { return cos($x); };
        $sin = function($x) { return sin($x); };

        $radius = function($lat) use ($equatorialRadiusInKm, $polarRadiusInKm, $sq, $sqr, $cos, $sin) {
            return $sqr(($sq($equatorialRadiusInKm * $equatorialRadiusInKm * $cos($lat)) + $sq($polarRadiusInKm * $polarRadiusInKm * $sin($lat))) / ($sq($equatorialRadiusInKm * $cos($lat)) + $sq($polarRadiusInKm * $sin($lat))));
        };

        $lat1 = $this->lat1 * M_PI / 180;
        $lon1 = $this->lon1 * M_PI / 180;
        $lat2 = $this->lat2 * M_PI / 180;
        $lon2 = $this->lon2 * M_PI / 180;

        $R1 = $radius($lat1);
        $x1 = $R1 * $cos($lat1) * $cos($lon1);
        $y1 = $R1 * $cos($lat1) * $sin($lon1);
        $z1 = $R1 * $sin($lat1);

        $R2 = $radius($lat2);
        $x2 = $R2 * $cos($lat2) * $cos($lon2);
        $y2 = $R2 * $cos($lat2) * $sin($lon2);
        $z2 = $R2 * $sin($lat2);

        return $sqr($sq($x1 - $x2) + $sq($y1 - $y2) + $sq($z1 - $z2));
    }
}
