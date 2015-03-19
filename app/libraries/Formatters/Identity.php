<?php
namespace PhalconRest\Libraries\Formatters;

/**
 * TBWritten
 */
class Identity
{

    /**
     * mask the first 5 numbers and retun only the last 4
     *
     * @param string $ssn            
     * @param string $reveal
     *            show the full social?
     * @return string
     */
    function maskSSN($ssn, $reveal = false)
    {
        if ($reveal == false)
            return '###-##-' . substr($ssn, - 4);
    }
}