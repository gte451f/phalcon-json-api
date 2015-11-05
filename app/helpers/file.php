<?php
/*
 |--------------------------------------------------------------------------
 | File Stream Modes
 |--------------------------------------------------------------------------
 |
 | These modes are used when working with fopen()/popen()
 |
 */

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

function write_file($path, $data, $mode = FOPEN_WRITE_CREATE_DESTRUCTIVE)
{
    if ( ! $fp = @fopen($path, $mode))
    {
        return FALSE;
    }

    flock($fp, LOCK_EX);
    fwrite($fp, $data);
    flock($fp, LOCK_UN);
    fclose($fp);

    return TRUE;
}