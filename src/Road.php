<?php
namespace src;

Abstract class Road
{

    // Setting Defaults
    protected $allowedSpeed = 70;
    protected $range = 200;

    protected $timeTakenForMapping = 0;
    protected $distanceCovered = 0;
    protected $refuelled = 0;

    protected $distanceToGarage;
    protected $speedLimit;
    public $distanceToMap;

    const DISTANCE_TO_FUEL_PUMP = 5;


    /**
     * SpeedLimit for Urban & Rural has to be implemented based upon their configurations
     *
     * @return void
     */
    abstract public function setSpeedLimit();


    /**
     * Before we start mapping actual length,
     *  Distance from Garage to City
     *  Time elapsed in traveling from Garage to City at Regular Speed
     *
     * @param float $distance
     * @return void
     */
    protected function startFromGarage(float $distance) {
        $this->distanceToGarage = $distance;
        $this->distanceCovered += $distance;
        $this->timeTakenForMapping += ( ($distance / $this->allowedSpeed) * 60 );

        return;
    }


    /**
     * When the DistaceCanBeCovered reaches 5, Refuelling to continue.
     * Refuelling adds 
     *      30 Mins to the time taken for mapping
     *      10 Kms to Detour Round Trip
     *      Number of times Refuelled
     *
     * @return void
     */
    public function refuel() : void {
        $this->timeTakenForMapping += 30;
        $this->distanceCovered += 10;
        $this->refuelled++;

        return;
    }

    
    /**
     * Mapping Logic
     * Car can cover distance of Range - Distance from Fuel Pump at a time
     * Time taken will depend upon the Speed Limit( Restriction / Relaxation )
     * Mapping ends when Car reaches back to Garage
     *
     * @return array
     */
    public function startMapping() : array {
        $distanceCanBeCovered = $this->range - self::DISTANCE_TO_FUEL_PUMP;

        for ($i = $this->distanceToMap; $i >= $distanceCanBeCovered; $i-=$distanceCanBeCovered) {
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
        
        if ( $this->distanceToMap > 0 ) {
            $this->mapRemainingAndReturnToGarage($distanceCanBeCovered);
        } 

        return [
            'Time taken to Map' => intdiv($this->timeTakenForMapping, 60) . " Hrs " . ($this->timeTakenForMapping%60) . " Mins",
            'Total Distance Travelled' => round($this->distanceCovered, 2) . " Kms",
            'Number of times Refuelled' => $this->refuelled,
        ];
    }


    /**
     * Function was written to avoid looping and perform calculations in a single attempt
     *
     * @param integer $multiplier
     * @param float $distanceCanBeCovered
     * @return void
     */
    private function coverDistance(int $multiplier, float $distanceCanBeCovered) : void {
        $this->distanceToMap -= ($distanceCanBeCovered * $multiplier);
        $this->distanceCovered += ($distanceCanBeCovered * $multiplier);
        $this->timeTakenForMapping += ( ($distanceCanBeCovered / $this->speedLimit) * 60 * $multiplier );

        return;
    }


    /**
     * The last portion of the Mapping includes
     *  1. Check for adaquet Fuel
     *  2. Mapping the remaining portion
     *  3. Return to Garage
     *
     * @param float $distanceCanBeCovered
     * @return void
     */
    private function mapRemainingAndReturnToGarage(float $distanceCanBeCovered) : void {

        if ( ($this->distanceToMap + self::DISTANCE_TO_FUEL_PUMP) > $distanceCanBeCovered ) {
            $this->refuel();
            $distanceCanBeCovered = $this->range - self::DISTANCE_TO_FUEL_PUMP;
        }

        if ( ($this->distanceToMap + $this->distanceToGarage) > $distanceCanBeCovered ) {

            $this->refuel();
        }
        $this->distanceCovered += ($this->distanceToMap + $this->distanceToGarage);
        $this->timeTakenForMapping += ($this->distanceToMap / $this->speedLimit) * 60;
        $this->timeTakenForMapping += ($this->distanceToGarage / $this->allowedSpeed) * 60;

        return;
    }

}
