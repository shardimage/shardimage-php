<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\loggers;

use shardimage\shardimagephp\helpers\LoggerHelper;

class SysLogger extends BaseLogger
{
    /**
     * @var string
     */
    protected $ident;

    /**
     * @var int
     */
    protected $option;

    /**
     * @var int
     */
    protected $facility;

    /**
     * @param string $ident [optional] The string ident is added to each message. See `openlog()`.
     * @param int $option [optional] The option argument is used to indicate what logging options will
     * be used when generating a log message. See `openlog()`.
     * @param int $facility [optional] The facility argument is used to specify what type of program is logging the
     * message. See `openlog()`.
     */
    public function __construct($ident = 'shardimage-php', $option = LOG_PID, $facility = LOG_USER)
    {
        $this->ident = $ident;
        $this->option = $option;
        $this->facility = $facility;
    }

    /**
     * @param string $ident The string ident is added to each message. See `openlog()`.
     */
    public function setIdent($ident)
    {
        $this->ident = $ident;
    }

    /**
     * @param int $option The option argument is used to indicate what logging options will
     * be used when generating a log message. See `openlog()`.
     */
    public function setOption($option)
    {
        $this->option = $option;
    }

    /**
     * @param int $facility The facility argument is used to specify what type of program is logging the
     * message. See `openlog()`.
     */
    public function setFacility($facility)
    {
        $this->ident = $facility;
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = [])
    {
        openlog($this->ident, $this->option, $this->facility);
        syslog(LoggerHelper::psrToPhpLevel($level), $this->interpolate($message, $context));
        closelog();
    }
}
