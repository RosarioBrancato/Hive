<?php


namespace Util;


use DateTime;
use DateTimeZone;

class DateUtils
{

    public static function GetTimezones()
    {
        //https://www.pontikis.net/tip/?id=24

        $zones_array = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return $zones_array;
    }

    public static function GetTimezonesAsDropDown($selected = "")
    {
        $timezones = DateUtils::GetTimezones();
        ?>
        <select name="timezone" class="form-control" required>
            <?php foreach ($timezones as $timezone) { ?>
                <option value="<?php echo $timezone["zone"]; ?>" <?php echo $timezone["zone"] === $selected ? "selected" : ""; ?>><?php echo $timezone['zone'] . ' - ' . $timezone['diff_from_GMT']; ?></option>
            <?php } ?>
        </select>
        <?php
    }

    public static function ConvertUTCToTimezone($timestamp, $timezone)
    {
        try {
            $dt = new DateTime($timestamp, new DateTimeZone('UTC'));
            $dt->setTimezone(new DateTimeZone($timezone));
            $date = $dt->format('d.m.Y H:i');

        } catch (\Exception $e) {
            error_log($e->getMessage());
            $date = "";
        }

        return $date;
    }

}