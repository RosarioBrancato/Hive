<?php


namespace Util;


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
            return $value;
        }
    }

}