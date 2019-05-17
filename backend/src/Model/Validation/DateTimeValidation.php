<?php
namespace App\Model\Validation;

use Cake\I18n\Time;
use Cake\Validation\Validation;

/**
 * Define custom date and time validate rules
 */
class DateTimeValidation extends Validation
{

    /**
     * RegExp to test a string for a full ISO 8601 Date
     * Does not do any sort of date validation, only checks if the string is according to the ISO 8601 spec.
     *  YYYY-MM-DDThh:mm:ss
     *  YYYY-MM-DDThh:mm:ssTZD
     *  YYYY-MM-DDThh:mm:ss.sTZD
     * @see: https://www.w3.org/TR/NOTE-datetime
     * @type {RegExp}
     *
     * @param String $check
     * @return Bool
     */
    public static function isISO8601(string $check): bool
    {
        return (bool) preg_match(
            '/^\d{4}-\d\d-\d\dT\d\d:\d\d:\d\d(\.\d+)?(([+-]\d{2,4}(:\d\d)?)|Z)?$/i',
            $check
        );
    }
}
