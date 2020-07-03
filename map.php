<?php
include_once 'vendor/autoload.php';
include_once 'includes/Functions.php';

use src\RoadFactory;

try {
    for($i=1; $i < $argc; $i++) {
        list($key, $val) = explode('=', $argv[$i]);
        $key = substr($key, 2);
        $input[$key] = $val;
    }

    validateInputs($input);
    
    $obj = RoadFactory::roadObject(strtolower($input['road_type']));
    $obj->distanceToMap = $input['road_length'];
    $response = $obj->startMapping();
    
    // Used Console_Table for User Friendly Display. :D
    $table = new Console_Table();
    $table->setHeaders(['Title', 'Value']);
    foreach ($response as $key => $val) {
        $table->addRow([$key, $val]);
    }
    
    echo $table->getTable();
} catch(\Exception $ex) {
    echo "Error: " . $ex->getMessage();
}
