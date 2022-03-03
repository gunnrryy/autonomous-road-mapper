<?php

declare(strict_types=1);

namespace src;

abstract class Road
{
    public const DISTANCE_TO_FUEL_PUMP = 5;

    public $distanceToMap;

    /**
     * Setting Default allowed speed.
     *
     * @var int
     */
    protected $allowedSpeed = 70;

    /**
     * Setting Default Range.
     *
     * @var int
     */
    protected $range = 200;

    /**
     * @var int
     */
    protected $timeTakenForMapping = 0;

    /**
     * @var int
     */
    protected $distanceCovered = 0;

    /**
     * @var int
     */
    protected $refuelled = 0;

    protected $distanceToGarage;

    protected $speedLimit;

    /**
     * SpeedLimit for Urban & Rural has to be implemented based upon their configurations.
     */
    abstract public function setSpeedLimit(): void;

    /**
     * When the DistaceCanBeCovered reaches 5, Refuelling to continue.
     * Refuelling adds
     *      30 Mins to the time taken for mapping
     *      10 Kms to Detour Round Trip
     *      Number of times Refuelled.
     */
    public function refuel(): void
    {
        $this->timeTakenForMapping += 30;
        $this->distanceCovered += 10;
        ++$this->refuelled;

        return;
    }

    /**
     * Mapping Logic
     * Car can cover distance of Range - Distance from Fuel Pump at a time
     * Time taken will depend upon the Speed Limit( Restriction / Relaxation )
     * Mapping ends when Car reaches back to Garage.
     */
    public function startMapping(): array
    {
        $distanceCanBeCovered = $this->range - self::DISTANCE_TO_FUEL_PUMP;

        for ($i = $this->distanceToMap; $i >= $distanceCanBeCovered; $i -= $distanceCanBeCovered) {
            if ($this->distanceToMap > $distanceCanBeCovered) {
                $this->distanceToMap -= $distanceCanBeCovered;
                $this->distanceCovered += $distanceCanBeCovered;
                $this->timeTakenForMapping += ($distanceCanBeCovered / $this->speedLimit) * 60;
                $this->refuel();
            } else {
                $this->distanceToMap = 0;
                $distanceCanBeCovered -= $this->distanceToMap;
            }
        }

        if ($this->distanceToMap > 0) {
            $this->mapRemainingAndReturnToGarage($distanceCanBeCovered);
        }

        return $this->getResponse();
    }

    /**
     * Before we start mapping actual length,
     * Distance from Garage to City
     * Time elapsed in traveling from Garage to City at Regular Speed.
     */
    protected function startFromGarage(float $distance): void
    {
        $this->distanceToGarage = $distance;
        $this->distanceCovered += $distance;
        $this->timeTakenForMapping += (($distance / $this->allowedSpeed) * 60);

        return;
    }

    /**
     * Function was written to avoid looping and perform calculations in a single attempt.
     */
    /*
    private function coverDistance(int $multiplier, float $distanceCanBeCovered): void
    {
        $this->distanceToMap -= ($distanceCanBeCovered * $multiplier);
        $this->distanceCovered += ($distanceCanBeCovered * $multiplier);
        $this->timeTakenForMapping += (($distanceCanBeCovered / $this->speedLimit) * 60 * $multiplier);

        return;
    }
    */

    /**
     * The last portion of the Mapping includes
     *  1. Check for adaquet Fuel
     *  2. Mapping the remaining portion
     *  3. Return to Garage.
     */
    private function mapRemainingAndReturnToGarage(float $distanceCanBeCovered): void
    {
        if (($this->distanceToMap + self::DISTANCE_TO_FUEL_PUMP) > $distanceCanBeCovered) {
            $this->refuel();
            $distanceCanBeCovered = $this->range - self::DISTANCE_TO_FUEL_PUMP;
        }

        if (($this->distanceToMap + $this->distanceToGarage) > $distanceCanBeCovered) {
            $this->refuel();
        }
        $this->calculateRemaining();
        $this->returnToGarage();

        return;
    }

    private function calculateRemaining(): void
    {
        $this->distanceCovered += $this->distanceToMap + $this->distanceToGarage;
        $this->timeTakenForMapping += ($this->distanceToMap / $this->speedLimit) * 60;

        return;
    }

    private function returnToGarage(): void
    {
        $this->timeTakenForMapping += ($this->distanceToGarage / $this->allowedSpeed) * 60;

        return;
    }

    /**
     * Returns the response array.
     */
    private function getResponse(): array
    {
        return [
            'Time taken to Map' => floor($this->timeTakenForMapping / 60).' Hrs '.($this->timeTakenForMapping % 60).' Mins',
            'Total Distance Travelled' => round($this->distanceCovered, 2).' Kms',
            'Number of times Refuelled' => $this->refuelled,
        ];
    }
}
