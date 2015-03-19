<?php
namespace PhalconRest\Libraries\MessageBag;

/**
 * a central place to store messages destined for the user
 * error, validation, alerts, success
 *
 * @author jjenkins
 *        
 */
class MessageBag
{

    /**
     * store all error messages here
     * @var array
     */
    private $messageList = array();

    private $glue = '</br> - ';

    /**
     * 
     * @param string $message
     */
    public function set($message)
    {
        $this->messageList[] = $message;
    }

    /**
     * 
     * @return multitype:
     */
    public function get()
    {
        return $this->messageList;
    }

    /**
     * 
     * @return string
     */
    public function getString()
    {
        return implode($this->glue, $this->messageList);
    }
}