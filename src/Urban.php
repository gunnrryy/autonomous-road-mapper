<?php
namespace src;

use src\Road;

class Urban extends Road
{
    const DISTANCE_FROM_GARAGE = 20;

    // Assuming Restrictions and Relaxations in Percentage only
    const SPEED_RESTRICTION = 0.25;

    // Due to Urban Traffic
    const RANGE_DROP = 0.25;

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
        $this->speedLimit = $this->allowedSpeed * (1 - self::SPEED_RESTRICTION);

        return;
    }
}
