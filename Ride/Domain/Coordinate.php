<?php

namespace Ride\Domain;

use Exception;

class Coordinate
{
    private string $longitude;
    private string $latitude;

    /**
     * @throws Exception
     */
    public function __construct(string $latitude, string $longitude)
    {
        $floatLatitude = $this->transformCoordinateValueToFloat($latitude);
        $floatLongitude = $this->transformCoordinateValueToFloat($longitude);
        if($floatLatitude < -90 || $floatLatitude > 90) throw new Exception("Invalid latitude");
        if($floatLongitude < -180 || $floatLongitude > 180) throw new Exception("Invalid longitude");
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }


    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function transformCoordinateValueToFloat(string $coordinate): float
    {
        $numberTotalOfDigits = strlen(preg_replace('/[^0-9]/', '', $coordinate));
        ini_set("precision", $numberTotalOfDigits);
        return floatval($coordinate);
    }
}
