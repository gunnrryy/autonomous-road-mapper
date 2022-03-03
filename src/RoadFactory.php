<?php

declare(strict_types=1);

namespace src;

class RoadFactory
{
    /**
     * RoadFactory class to return the class object based upon input.
     *
     * @throws Exception when roadType isn't from (urban OR rural)
     */
    public static function roadObject(string $roadType)
    {
        if ('urban' === $roadType) {
            $obj = new Urban();
        } elseif ('rural' === $roadType) {
            $obj = new Rural();
        } else {
            throw new \Exception('Invalid Road Type');
        }

        return $obj;
    }
}
