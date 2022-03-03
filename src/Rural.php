<?php

declare(strict_types=1);

namespace src;

final class Rural extends Road
{
    public const DISTANCE_FROM_GARAGE = 50;

    // Assuming Restrictions and Relaxations in Percentage only
    public const SPEED_RELAXATION = 0.15;

    // Due to No Traffic
    public const RANGE_DROP = 0;

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
        $this->speedLimit = $this->allowedSpeed * (1 + self::SPEED_RELAXATION);

        return;
    }
}
