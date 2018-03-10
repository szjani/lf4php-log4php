<?php
declare(strict_types=1);

namespace lf4php\impl;

/**
 * StaticLoggerBinder for log4php.
 *
 * @package lf4php\impl
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
final class StaticLoggerBinder
{
    /**
     * @var StaticLoggerBinder
     */
    public static $SINGLETON;

    private $loggerFactory;

    public static function init() : void
    {
        self::$SINGLETON = new StaticLoggerBinder();
        self::$SINGLETON->loggerFactory = new Log4phpLoggerFactory();
    }

    /**
     * @return Log4phpLoggerFactory
     */
    public function getLoggerFactory() : Log4phpLoggerFactory
    {
        return $this->loggerFactory;
    }
}
StaticLoggerBinder::init();
