<?php


/**
 * Check for key => value paired input for non-empty
 *
 * @param array $input
 * @throws Exception 
 * @return void
 */
function validateInputs(array $input) : void {
    foreach ($input as $key => $value) {
        if ( empty($key) ) {
            throw new \Exception("Key can not be empty. Please provide valid inputs");
        }

        if ( empty($value) ) {
            throw new \Exception("Value can not be empty. Please provide valid value for :" . $key);
        }
    }
    if ( !in_array($input['road_type'], ['urban', 'rural']) ) {
        throw new \Exception("Road Type can either be `urban` or `rural`");
    }

    return;
}