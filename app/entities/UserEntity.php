<?php
namespace PhalconRest\Entities;

/**
 * Class UserEntity
 *
 * An entity in the API isn't required, this one is included only as an example.
 * Entities are often written to implement business logic outside the scope of the model
 * While a model is only concerned with rules INSIDE the model, an Entity is designed to deal with more
 * far reaching business logic like rules that cross multiple models.
 *
 * If no entity is provided, the API will use the default API Entity instead
 *
 * @package PhalconRest\Entities
 */
class UserEntity extends \PhalconRest\API\Entity
{
}