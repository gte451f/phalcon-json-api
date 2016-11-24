<?php
namespace PhalconRest\Models;

class Customers extends \PhalconRest\API\BaseModel
{

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $type;

    /**
     *
     * @var integer
     */
    public $revenue;

    /**
     * this model's parent model
     *
     * @var string
     */
    public static $parentModel = 'Users';

    /**
     *
     * (non-PHPdoc)
     *
     * @see \PhalconRest\API\BaseModel::initialize()
     */
    public function initialize()
    {
        parent::initialize();
        $this->hasOne("user_id", Users::class, "id", ['alias' => 'Users']);
        $this->hasMany("user_d", Addresses::class, "user_id", ['alias' => 'Addresses']);
    }
}
