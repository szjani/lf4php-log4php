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

/**
 * Extends log4php Logger class for proper location logging.
 *
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class Log4phpLoggerAdapter extends \Logger implements Logger
{
    private $logger;

    public function __construct(\Logger $logger)
    {
        $this->logger = $logger;
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
        if ($this->isDebugEnabled()) {
            $this->logger->debug(MessageFormatter::format($format, $params), $e);
        }
    }

    public function error($format, $params = array(), Exception $e = null)
    {
        if ($this->isErrorEnabled()) {
            $this->logger->error(MessageFormatter::format($format, $params), $e);
        }
    }

    public function info($format, $params = array(), Exception $e = null)
    {
        if ($this->isInfoEnabled()) {
            $this->logger->info(MessageFormatter::format($format, $params), $e);
        }
    }

    public function trace($format, $params = array(), Exception $e = null)
    {
        if ($this->isTraceEnabled()) {
            $this->logger->trace(MessageFormatter::format($format, $params), $e);
        }
    }

    public function warn($format, $params = array(), Exception $e = null)
    {
        if ($this->isWarnEnabled()) {
            $this->logger->warn(MessageFormatter::format($format, $params), $e);
        }
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
