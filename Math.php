<?php

namespace fgh151\modules\geo;


class Math
{

    /**
     * Формула Хаверсина
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @return int
     */
    public static function calcDistance($x1, $y1, $x2, $y2)
    {
        $r = 6378137;
        $dLat = self::rad($x2 - $x1);
        $dLong = self::rad($y2 - $y1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(self::rad($x1)) * cos(self::rad($x2)) *
            sin($dLong / 2) * sin($dLong / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $r * $c;
        return $d; //расстояние в метрах
    }


    /**
     * @param $x
     * @return float
     */
    public static function rad($x)
    {
        return $x * M_PI / 180;
    }


    /**
     * @param $objects
     * @param $lat
     * @param $lon
     * @return array
     */
    public static function sortByDistance($objects, $lat, $lon)
    {
        $result = [];
        foreach($objects as $index => $object){
            $distanse = intval(self::calcDistance($lat, $lon, $object->lat, $object->lon));
            while (key_exists($distanse, $result)) {
                $distanse = $distanse++;
            }
            $result[intval($distanse)] = $object;
        }
        ksort($result);
        return array_values($result);
    }

}