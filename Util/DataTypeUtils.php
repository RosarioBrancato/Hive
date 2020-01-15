<?php


namespace Util;


use Cassandra\Date;
use DateTime;

class DataTypeUtils
{

    public static function ConvertToBit($value)
    {
        if (is_null($value)) {
            return null;
        } else if (empty($value)) {
            return 0;
        } else {
            return 1;
        }
    }

    public static function CheckDefaultValue($value)
    {
        if (is_null($value)) {
            return null;
        } else if (empty($value)) {
            return null;
        } else {

            try {
                $dt = new DateTime($value);
                return $dt->format('Y-m-d H:i:s');

            } catch (\Exception $e) {
                error_log($e->getMessage());
                return null;
            }
        }
    }

}