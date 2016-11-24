<?php
/**
 * store simple functions that are essential to app operation
 */

/**
 * convert various dates to a common format
 *
 * @param string $date
 * @return bool|string
 */
function us_date($date = null)
{
    switch ($date) {
        case '':
        case '--':
        case '//':
        case null:
        case '0000-00-00':
        case '0000-00-00 00:00:00':
            return '&nbsp;';
            break;

        default:
            return date("m/d/Y", strtotime($date));
            break;
    }
}

/*
 * |--------------------------------------------------------------------------
 * | File Stream Modes
 * |--------------------------------------------------------------------------
 * |
 * | These modes are used when working with fopen()/popen()
 * |
 */
define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

function write_file($path, $data, $mode = FOPEN_WRITE_CREATE_DESTRUCTIVE)
{
    if (!$fp = @fopen($path, $mode)) {
        return false;
    }

    flock($fp, LOCK_EX);
    fwrite($fp, $data);
    flock($fp, LOCK_UN);
    fclose($fp);

    return true;
}