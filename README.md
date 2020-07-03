# Autonomous Car Mapper Task

As a user, I want an autonomous car to map roads. The car can drive itself up to 200km after refueling. The car should reach a fuel station and refuel itself before it runs out of petrol. Car always starts from a garage outside of the area with full fuel and returns to the garage once the mapping task is complete. 

I want to run a command “php map.php --road_type=urban --road_length=900” and I want to see the below output after the mapping task is completed. 

  - total time spent on the mapping task
  - number of times refuelled
  - total distance travelled


# Conditions

  - --road_type accepts urban or rural
  - On urban roads, the maximum range of the car drops by 25% due to traffic
  - The garage is 20km from urban areas  and 50km from rural areas
  - From any point, the car can refuel itself by taking a detour that is a round-trip of 10km. 
  - Time to refuel is 30 mins. There are no fuel pumps between the city and the garage.
  - Speed limit imposed by the police is 70kmph. Urban traffic causes a 25% decrease in the  limit. Rural areas allow a relaxation of 15% on the limit.
  - The car must travel the entire length of the road and return to the garage to mark the mapping task as complete.
  - While a web UI is not expected, the interface on the terminal should have good user experience


### Installation

```sh
$ git clone git@github.com:gunnrryy/autonomous-road-mapper.git
$ cd autonomous-road-mapper
$ composer install
```

Open your favorite Terminal and run the commands.


```sh
$ php map.php --road_type=urban --road_length=900
+---------------------------+----------------+
| Title                     | Value          |
+---------------------------+----------------+
| Time taken to Map         | 20 Hrs 42 Mins |
| Total Distance Travelled  | 1000 Kms       |
| Number of times Refuelled | 6              |
+---------------------------+----------------+
```

For Testing run the following command.


```sh
$ vendor/bin/phpunit tests/Urban
PHPUnit 9.2.5 by Sebastian Bergmann and contributors.

..                                                                  2 / 2 (100%)

Time: 00:00.065, Memory: 6.00 MB

OK (2 tests, 2 assertions)
```

License
----


