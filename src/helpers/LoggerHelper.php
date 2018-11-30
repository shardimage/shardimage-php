<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\helpers;

use Psr\Log\LogLevel;

class LoggerHelper
{
    /**
     * @var string[]
     */
    private static $psrLogLevels = [
        LOG_EMERG => LogLevel::EMERGENCY,
        LOG_ALERT => LogLevel::ALERT,
        LOG_CRIT => LogLevel::CRITICAL,
        LOG_ERR => LogLevel::ERROR,
        LOG_WARNING => LogLevel::WARNING,
        LOG_NOTICE => LogLevel::NOTICE,
        LOG_INFO => LogLevel::INFO,
        LOG_DEBUG => LogLevel::DEBUG,
    ];

    /**
     * @param int $level PHP log level.
     * @param string $default [optional] The default PSR log level.
     *
     * @return string PSR log level.
     */
    public static function phpToPsrLevel($level, $default = LogLevel::DEBUG): string
    {
        return isset(self::$psrLogLevels[$level]) ? self::$psrLogLevels[$level] : $default;
    }

    /**
     * @param string $level PSR log level.
     * @param int $default [optional] The default PHP log level.
     *
     * @return int PHP log level.
     */
    public static function psrToPhpLevel($level, $default = LOG_DEBUG): string
    {
        $psrLevel = array_search($level, self::$psrLogLevels);

        return $psrLevel ?: $default;
    }

    /**
     * Replaces the lines containing binary strings with a human readable replacement.
     *
     * @param string $message
     *
     * @return string
     */
    public static function replaceBinaryStrings($message)
    {
        $lines = explode("\r\n", $message);

        foreach ($lines as &$line) {
            if (!mb_check_encoding($line, 'utf-8')) {
                $line = '<' . strlen($line) . ' bytes binary content>';
            }
        }

        return implode("\r\n", $lines);
    }
}
