<?php
namespace PhalconRest\Libraries\Authentication;

use Phalcon\DI\Injectable;
use \PhalconRest\Libraries\Authentication\UserProfile;
use \PhalconRest\Exception\HTTPException;
use \PhalconRest\Models\Users;
use \PhalconRest\Models\PhalconRest\Models;

/**
 * custom to this application but relies on the authentication library built
 * into the PhalconREST API
 *
 * @author jjenkins
 *
 */
final class Local extends Injectable implements \PhalconRest\Authentication\AdapterInterface
{


    /**
     * write your own authentication logic here
     * check a local database for a valid user account or whatev
     *
     * @param string $email
     * @param false $password
     * @return boolean
     */
    function authenticate($email, $password)
    {
        return true;
    }
}