<?php
namespace PhalconRest\Models;

class Addresses extends \PhalconRest\API\BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $street;

    /**
     *
     * @var string
     */
    public $city;

    /**
     *
     * @var string
     */
    public $state;

    /**
     *
     * @var string
     */
    public $zip;

    /**
     *
     * (non-PHPdoc)
     *
     * @see \PhalconRest\API\BaseModel::initialize()
     */
    public function initialize()
    {
        parent::initialize();
        
        $this->singularName = 'Address';
        
        $this->belongsTo("user_id", "PhalconRest\Models\Users", "id", array(
            'alias' => 'Users'
        ));
    }

    /**
     * this would normally be auto detected but
     * must extend to account for unusual singular/plural naming
     *
     * (non-PHPdoc)
     *
     * @see \PhalconRest\API\BaseModel::getModelName()
     */
    public function getModelName($type = 'plural')
    {
        if ($type == 'plural') {
            return 'Addresses';
        } else {
            return 'Address';
        }
    }

    /**
     * this would normally be auto detected but
     * must extend to account for unusual singular/plural naming
     *
     * (non-PHPdoc)
     *
     * @see \PhalconRest\API\BaseModel::getTableName()
     */
    public function getTableName($type = 'plural')
    {
        if ($type == 'plural') {
            return 'addresses';
        } else {
            return 'address';
        }
    }
}
