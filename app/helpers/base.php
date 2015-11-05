<?php

/**
 * store low level functions that are essential to system operation
 * TODO: Make these services or libraries in DI?
 */

/**
 * logic used to auto load the correct config based on environment
 *
 * @return array
 */
function array_merge_recursive_replace()
{
    $arrays = func_get_args();
    $base = array_shift($arrays);
    
    foreach ($arrays as $array) {
        reset($base);
        while (list ($key, $value) = @each($array)) {
            if (is_array($value) && @is_array($base[$key])) {
                $base[$key] = array_merge_recursive_replace($base[$key], $value);
            } else {
                $base[$key] = $value;
            }
        }
    }
    return $base;
}

/**
 * convert various dates to a common format
 * 
 * @param string $date
 */
function us_date($date = null)
{
    switch ($date) {
        case '':
        case '--':
        case '//':
        case NULL:
        case '0000-00-00':
        case '0000-00-00 00:00:00':
            return '&nbsp;';
            break;

        default:
            return date("m/d/Y", strtotime($date));
            break;
    }
}