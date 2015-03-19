<?php
namespace PhalconRest\Libraries\Formatters;

/**
 * port former helpers from CI
 * pretty inflexible, built for mysql based timestamps
 *
 *        
 */
class Date
{

    /**
     * Given a MYSQL date, return a US formated date
     * Handle false, 0000-00-00 and null as well
     *
     * @param string $date            
     * @return string US formatted date
     */
    public function formatUSDate($date = null)
    {
        switch ($date) {
            case '':
            case '--':
            case '//':
            case NULL:
            case '0000-00-00':
            case '0000-00-00 00:00:00':
                return '&nbsp;';
                break;
            
            default:
                return date("m/d/Y", strtotime($date));
                break;
        }
    }

    /**
     * Given a MYSQL datetime, return a US formated datetme
     * Handle false, 0000-00-00 and null as well
     *
     * @param string $date            
     * @return string US formatted date
     */
    public function formatUSDateTime($datetime = null)
    {
        switch ($datetime) {
            case '':
            case '--':
            case '//':
            case NULL:
            case '0000-00-00':
            case '0000-00-00 00:00:00':
                return '&nbsp;';
                break;
            
            default:
                return date("m/d/Y g:i a", strtotime($datetime));
                break;
        }
    }
}