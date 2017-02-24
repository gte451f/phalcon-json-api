<?php
namespace PhalconRest\Libraries\Security;

use Phalcon\DI\Injectable;

/**
 * A very simple service that blocks or allows access to requested end points
 * All manner of logic could be programmed in a class and it is up to the developer to write their own.
 *
 */
final class SecurityService extends Injectable
{

    /**
     * this dummy function will automatically block access to this end point all the time
     *
     * @return bool
     */
    public function checkUserPermissions()
    {
        // flip this to false to deny access or true to allow access
        return false;
    }

}