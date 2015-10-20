<?php
/*
 * Copyright (c) 2012 Janos Szurovecz
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

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

    public static function init()
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

    public function getName()
    {
        return $this->logger->getName();
    }

    /**
     * @return \Logger
     */
    public function getLog4phpLogger()
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

    public function isDebugEnabled()
    {
        return $this->logger->isDebugEnabled();
    }

    public function isErrorEnabled()
    {
        return $this->logger->isErrorEnabled();
    }

    public function isInfoEnabled()
    {
        return $this->logger->isInfoEnabled();
    }

    public function isTraceEnabled()
    {
        return $this->logger->isTraceEnabled();
    }

    public function isWarnEnabled()
    {
        return $this->logger->isWarnEnabled();
    }
}
Log4phpLoggerAdapter::init();
