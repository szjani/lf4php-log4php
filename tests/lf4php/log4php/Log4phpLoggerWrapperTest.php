<?php
/*
 * Copyright (c) 2012 Szurovecz János
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

namespace lf4php\log4php;

use Exception;
use lf4php\helpers\MessageFormatter;
use Logger;
use PHPUnit_Framework_TestCase;

/**
 * @author Szurovecz János <szjani@szjani.hu>
 */
class Log4phpLoggerWrapperTest extends PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $logger = Logger::getLogger('foo');
        $wrapper = new Log4phpLoggerWrapper($logger);
        self::assertEquals('foo', $wrapper->getName());
    }

    public function testGetLogger()
    {
        $logger = Logger::getLogger('foo');
        $wrapper = new Log4phpLoggerWrapper($logger);
        self::assertSame($logger, $wrapper->getLog4phpLogger());
    }

    public function testLogs()
    {
        $msg = 'Hello {}!';
        $params = array('World');
        $e = new Exception();

        $logger = $this->getMock('Logger', array(), array(), '', false);
        $logger
            ->expects(self::once())
            ->method('debug')
            ->with(MessageFormatter::format($msg, $params), $e);
        $logger
            ->expects(self::once())
            ->method('info')
            ->with(MessageFormatter::format($msg, $params), $e);
        $logger
            ->expects(self::once())
            ->method('error')
            ->with(MessageFormatter::format($msg, $params), $e);
        $logger
            ->expects(self::once())
            ->method('trace')
            ->with(MessageFormatter::format($msg, $params), $e);
        $logger
            ->expects(self::once())
            ->method('warn')
            ->with(MessageFormatter::format($msg, $params), $e);
        $logger
            ->expects(self::once())
            ->method('isDebugEnabled')
            ->will(self::returnValue(true));
        $logger
            ->expects(self::once())
            ->method('isInfoEnabled')
            ->will(self::returnValue(true));
        $logger
            ->expects(self::once())
            ->method('isErrorEnabled')
            ->will(self::returnValue(true));
        $logger
            ->expects(self::once())
            ->method('isTraceEnabled')
            ->will(self::returnValue(true));
        $logger
            ->expects(self::once())
            ->method('isWarnEnabled')
            ->will(self::returnValue(true));

        $wrapper = new Log4phpLoggerWrapper($logger);
        $wrapper->debug($msg, $params, $e);
        $wrapper->info($msg, $params, $e);
        $wrapper->error($msg, $params, $e);
        $wrapper->trace($msg, $params, $e);
        $wrapper->warn($msg, $params, $e);
    }

    public function testIsEnabledMethods()
    {
        $booleans = array(true, false);

        shuffle($booleans);
        $warnEnabled = $booleans[0];
        shuffle($booleans);
        $debugEnabled = $booleans[0];
        shuffle($booleans);
        $errorEnabled = $booleans[0];
        shuffle($booleans);
        $traceEnabled = $booleans[0];
        shuffle($booleans);
        $infoEnabled = $booleans[0];

        $logger = $this->getMock('Logger', array(), array(), '', false);
        $logger
            ->expects(self::once())
            ->method('isWarnEnabled')
            ->will(self::returnValue($warnEnabled));
        $logger
            ->expects(self::once())
            ->method('isDebugEnabled')
            ->will(self::returnValue($debugEnabled));
        $logger
            ->expects(self::once())
            ->method('isTraceEnabled')
            ->will(self::returnValue($traceEnabled));
        $logger
            ->expects(self::once())
            ->method('isErrorEnabled')
            ->will(self::returnValue($errorEnabled));
        $logger
            ->expects(self::once())
            ->method('isInfoEnabled')
            ->will(self::returnValue($infoEnabled));

        $wrapper = new Log4phpLoggerWrapper($logger);
        self::assertEquals($warnEnabled, $wrapper->isWarnEnabled());
        self::assertEquals($errorEnabled, $wrapper->isErrorEnabled());
        self::assertEquals($debugEnabled, $wrapper->isDebugEnabled());
        self::assertEquals($traceEnabled, $wrapper->isTraceEnabled());
        self::assertEquals($infoEnabled, $wrapper->isInfoEnabled());
    }

    /**
     * @test
     */
    public function noLogIfDisabled()
    {
        $logger = $this->getMock('Logger', array(), array(), '', false);
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::once())
            ->method('isDebugEnabled')
            ->will(self::returnValue(false));
        $wrapper = new Log4phpLoggerWrapper($logger);
        $wrapper->debug('no');
    }
}
