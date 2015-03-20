<?php
namespace PhalconRest\Controllers;

use PhalconRest\Util\Repeat as Repeat;

class UserController extends \PhalconRest\API\BaseController
{

    public function __construct($parseQueryString = true)
    {
        parent::__construct($parseQueryString);
        $repeat = new Repeat();
        $echo = $repeat->repeat("I was repeated");
    }
}