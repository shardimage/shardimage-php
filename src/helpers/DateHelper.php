<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\helpers;

class DateHelper
{
    public static function date($timestamp)
    {
        return date('Ymd', $timestamp);
    }

    public static function datetime($timestamp)
    {
        return date('YmdHis', $timestamp);
    }

    public static function intervalSecond($second)
    {
        return $second.'s';
    }

    public static function intervalMinute($minute)
    {
        return $minute.'m';
    }

    public static function intervalHour($hour)
    {
        return $hour.'h';
    }

    public static function intervalDay($day)
    {
        return $day.'d';
    }

    public static function intervalWeek($week)
    {
        return $week.'w';
    }

    public static function intervalMonth($month)
    {
        return $month.'mo';
    }

    public static function intervalYear($year)
    {
        return $year.'y';
    }
}
