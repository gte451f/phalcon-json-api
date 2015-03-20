<?php
namespace PhalconRest\Exceptions;

/**
 * where caught HTTP Exceptions go to die
 * 
 * @author jjenkins
 *        
 */
class GeneralException extends \Exception
{

    /**
     *
     * @param string $message            
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     *
     * @return void|boolean
     */
    public function send()
    {
        echo "exception";
    }
}