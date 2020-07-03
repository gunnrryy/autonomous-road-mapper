<?php
namespace src;

class RoadFactory
{

    /**
     * RoadFactory class to return the class object based upon input
     *
     * @param string $roadType
     * @throws Exception when roadType isn't from (urban OR rural)
     */
    public static function roadObject(string $roadType) {
        if ( "urban" === $roadType ) {
            $obj = new Urban();
        } else if ( "rural" === $roadType ) {
            $obj = new Rural();
        } else {
            throw new \Exception("Invalid Road Type");
        }

        return $obj;
    }
}