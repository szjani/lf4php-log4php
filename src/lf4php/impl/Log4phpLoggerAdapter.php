<?php
declare(strict_types=1);

namespace lf4php\impl;

use Exception;
use lf4php\helpers\MessageFormatter;
use lf4php\Logger;
use LoggerLevel;

/**
 * Extends log4php Logger class for proper location logging.
 *
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class Log4phpLoggerAdapter extends \Logger implements Logger
{
    private static $defaultLogFunction;
    private static $emptyLogFunction;

    private $logger;
    private $debugFunction;
    private $errorFunction;
    private $infoFunction;
    private $traceFunction;
    private $warnFunction;

    public static function init() : void
    {
        self::$defaultLogFunction = function(LoggerLevel $level, Log4phpLoggerAdapter $adapter, $format, $params = array(), Exception $e = null) {
            $adapter->logger->log($level, MessageFormatter::format($format, $params), $e);
        };
        self::$emptyLogFunction = function () {};
    }

    public function __construct(\Logger $logger)
    {
        $this->logger = $logger;

        $this->debugFunction = $logger->isDebugEnabled()
            ? self::$defaultLogFunction
            : self::$emptyLogFunction;
        $this->infoFunction = $logger->isInfoEnabled()
            ? self::$defaultLogFunction
            : self::$emptyLogFunction;
        $this->errorFunction = $logger->isErrorEnabled()
            ? self::$defaultLogFunction
            : self::$emptyLogFunction;
        $this->traceFunction = $logger->isTraceEnabled()
            ? self::$defaultLogFunction
            : self::$emptyLogFunction;
        $this->warnFunction = $logger->isWarnEnabled()
            ? self::$defaultLogFunction
            : self::$emptyLogFunction;
    }

    public function getName() : string
    {
        return $this->logger->getName();
    }

    /**
     * @return \Logger
     */
    public function getLog4phpLogger() : \Logger
    {
        return $this->logger;
    }

    public function debug($format, $params = array(), Exception $e = null)
    {
        call_user_func($this->debugFunction, LoggerLevel::getLevelDebug(), $this, $format, $params, $e);
    }

    public function error($format, $params = array(), Exception $e = null)
    {
        call_user_func($this->errorFunction, LoggerLevel::getLevelError(), $this, $format, $params, $e);
    }

    public function info($format, $params = array(), Exception $e = null)
    {
        call_user_func($this->infoFunction, LoggerLevel::getLevelInfo(), $this, $format, $params, $e);
    }

    public function trace($format, $params = array(), Exception $e = null)
    {
        call_user_func($this->traceFunction, LoggerLevel::getLevelTrace(), $this, $format, $params, $e);
    }

    public function warn($format, $params = array(), Exception $e = null)
    {
        call_user_func($this->warnFunction, LoggerLevel::getLevelWarn(), $this, $format, $params, $e);
    }

    public function isDebugEnabled() : bool
    {
        return $this->logger->isDebugEnabled();
    }

    public function isErrorEnabled() : bool
    {
        return $this->logger->isErrorEnabled();
    }

    public function isInfoEnabled() : bool
    {
        return $this->logger->isInfoEnabled();
    }

    public function isTraceEnabled() : bool
    {
        return $this->logger->isTraceEnabled();
    }

    public function isWarnEnabled() : bool
    {
        return $this->logger->isWarnEnabled();
    }
}
Log4phpLoggerAdapter::init();
