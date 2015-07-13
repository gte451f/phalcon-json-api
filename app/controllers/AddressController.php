<?php
namespace PhalconRest\Controllers;

use PhalconRest\API\BaseController;

/**
 * I am an empty controller because nearly all of my work was done in the parent class
 *
 * @author jjenkins
 *        
 */
class AddressController extends \PhalconRest\API\BaseController
{

    /**
     * extend to hard code the plural controller name
     *
     * @param string $parseQueryString            
     */
    public function __construct($parseQueryString = true)
    {
        $this->pluralName = 'Addresses';
        return parent::__construct($parseQueryString);
    }
}