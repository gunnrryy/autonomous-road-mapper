<?php

declare(strict_types=1);

namespace src;

final class Urban extends Road
{
    public const DISTANCE_FROM_GARAGE = 20;

    // Assuming Restrictions and Relaxations in Percentage only
    public const SPEED_RESTRICTION = 0.25;

    // Due to Urban Traffic
    public const RANGE_DROP = 0.25;

    public function __construct()
    {
        $this->startFromGarage(self::DISTANCE_FROM_GARAGE);
        $this->setSpeedLimit();
        $this->range = $this->range * (1 - self::RANGE_DROP);
    }

    /**
     * Implementing the SetSpeedLimit depending upon configuration settings.
     */
    public function setSpeedLimit(): void
    {
        $this->speedLimit = $this->allowedSpeed * (1 - self::SPEED_RESTRICTION);

        return;
    }
}
