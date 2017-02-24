<?php
namespace PhalconRest\Controllers;

use PhalconRest\Libraries\API\SecureController;
use PhalconRest\API\BaseController;

/**
 * To limit access to this end point, extend the secure controller instead
 */
class AddressController extends BaseController
// class AddressController extends SecureController
{
    public $pluralName = 'Addresses';
}