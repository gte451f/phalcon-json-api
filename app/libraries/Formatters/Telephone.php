<?php
namespace PhalconRest\Libraries\Formatters;

/**
 * port former helpers from CI
 * pretty inflexible, built for us telephones
 */
class Telephone
{

    /**
     * standard way to format a phone number
     * also handles ALPHA numbers
     *
     * @param string $phone
     * @param boolean $convert
     *            convert alpha to numbers
     * @param boolean $trim
     *            limit to 11 characters
     * @return boolean mixed
     */
    function formatTelephone($phone = '', $convert = true, $trim = true)
    {
        // If we have not entered a phone number just return empty
        if (empty($phone)) {
            return false;
        }

        // Strip out any extra characters that we do not need only keep letters and
        // numbers
        $phone = preg_replace("/[^0-9A-Za-z]/", "", $phone);
        // Keep original phone in case of problems later on but without special
        // characters
        $OriginalPhone = $phone;

        // If we have a number longer than 11 digits cut the string down to only 11
        // This is also only ran if we want to limit only to 11 characters
        if ($trim == true && strlen($phone) > 11) {
            $phone = substr($phone, 0, 11);
        }

        // Do we want to convert phone numbers with letters to their number
        // equivalent?
        // Samples are: 1-800-TERMINIX, 1-800-FLOWERS, 1-800-Petmeds
        if ($convert == true && !is_numeric($phone)) {
            $replace = array(
                '2' => array(
                    'a',
                    'b',
                    'c'
                ),
                '3' => array(
                    'd',
                    'e',
                    'f'
                ),
                '4' => array(
                    'g',
                    'h',
                    'i'
                ),
                '5' => array(
                    'j',
                    'k',
                    'l'
                ),
                '6' => array(
                    'm',
                    'n',
                    'o'
                ),
                '7' => array(
                    'p',
                    'q',
                    'r',
                    's'
                ),
                '8' => array(
                    't',
                    'u',
                    'v'
                ),
                '9' => array(
                    'w',
                    'x',
                    'y',
                    'z'
                )
            );

            // Replace each letter with a number
            // Notice this is case insensitive with the str_ireplace instead of
            // str_replace
            foreach ($replace as $digit => $letters) {
                $phone = str_ireplace($letters, $digit, $phone);
            }
        }

        $length = strlen($phone);
        // Perform phone number formatting here
        switch ($length) {
            case 7:

                // Format: xxx-xxxx
                return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1-$2", $phone);
            case 10:

                // Format: (xxx) xxx-xxxx
                return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "($1) $2-$3", $phone);
            case 11:

                // Format: x(xxx) xxx-xxxx
                return preg_replace("/([0-9a-zA-Z]{1})([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/",
                    "$1($2) $3-$4", $phone);
            default:

                // Return original phone if not 7, 10 or 11 digits long
                return $OriginalPhone;
        }
    }
}