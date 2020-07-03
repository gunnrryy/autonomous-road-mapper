<?php
namespace src;

use \src\Road;

class Rural extends Road
{
    const DISTANCE_FROM_GARAGE = 50;

    // Assuming Restrictions and Relaxations in Percentage only
    const SPEED_RELAXATION = 0.15;

    // Due to No Traffic
    const RANGE_DROP = 0;

    function __construct() {
        $this->startFromGarage(self::DISTANCE_FROM_GARAGE);
        $this->setSpeedLimit();
        $this->range = $this->range * ( 1 - self::RANGE_DROP);
    }

    /**
     * Implementing the SetSpeedLimit depending upon configuration settings
     *
     * @return void
     */
    public function setSpeedLimit() : void {
        $this->speedLimit = $this->allowedSpeed * (1 + self::SPEED_RELAXATION);

        return;
    }
}
