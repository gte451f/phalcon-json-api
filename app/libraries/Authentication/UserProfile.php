<?php
namespace PhalconRest\Libraries\Authentication;

use \PhalconRest\Exception\HTTPException;

/**
 * extend to provide application specific data to the profile object
 * or to fill in profile object with specific data
 *
 * @author jjenkins
 *
 */
class UserProfile extends \PhalconRest\Authentication\UserProfile
{


    /**
     * (non-PHPdoc)
     *
     * @see \PhalconRest\Authentication\UserProfile::loadProfileByToken()
     */
    public function loadProfile($search)
    {
        // use this hook to populate the userProfile object with your own custom properties like a username, email whatev
        return true;
    }


    /**
     * modify this function to return your own custom data you previously loaded into the user profile
     *
     * @param array $profile
     * @return \PhalconRest\Result\Result
     */
    public function getResult($profile = [])
    {
        $profile['username'] = $this->userName;
        $profile['token'] = $this->token;
        return parent::getResult($profile);
    }
}