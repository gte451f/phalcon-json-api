<?php
namespace PhalconRest\Models;

class Users extends \PhalconRest\API\BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $first_name;

    /**
     *
     * @var string
     */
    public $last_name;

    /**
     *
     * @var string
     */
    public $secret;

    /**
     *
     * (non-PHPdoc)
     *
     * @see \PhalconRest\API\BaseModel::initialize()
     */
    public function initialize()
    {
        parent::initialize();

        $this->blockColumns = array(
            'secret'
        );
        $this->hasMany("id", Addresses::class, "user_id", ['alias' => 'Addresses']);
    }
}
