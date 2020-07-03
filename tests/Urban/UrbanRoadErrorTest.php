<?php

namespace Urban;

use PHPUnit\Framework\TestCase;

class UrbanRoadErrorTest extends TestCase
{
    public function test_equal_output_asserts_equal()
    {
        $expected = "Error: Value can not be empty. Please provide valid value for :road_length";
        $actual = exec("php map.php --road_type=urban --road_length=");
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
        $actual = exec("php map.php --road_type=urban --road_length=");
        $this->assertNotEquals($actual, $expected);
    }
}
