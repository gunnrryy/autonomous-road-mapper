<?php

namespace Urban;

use PHPUnit\Framework\TestCase;

class MapUrbanRoadTest extends TestCase
{
    public function test_equal_output_asserts_equal()
    {
        $expected = <<<EOT
+---------------------------+----------------+
| Title                     | Value          |
+---------------------------+----------------+
| Time taken to Map         | 20 Hrs 42 Mins |
| Total Distance Travelled  | 1000 Kms       |
| Number of times Refuelled | 6              |
+---------------------------+----------------+
EOT;
        $actual = exec("php map.php --road_type=urban --road_length=900");
        $this->assertStringContainsString($actual, $expected);
    }

    public function test_different_output_assert_not_equal()
    {
        $expected = <<<EOT
+---------------------------+----------------+
| Title                     | Value          |
+---------------------------+----------------+
| Time taken to Map         | 20             |
| Total Distance Travelled  | 10 Kms         |
| Number of times Refuelled | 6              |
+---------------------------+----------------+
EOT;
        $actual = exec("php map.php --road_type=urban --road_length=900");
        $this->assertNotEquals($actual, $expected);
    }
}
