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
use Logger;
use LoggerLevel;
use Mockery;
use PHPUnit_Framework_TestCase;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class Log4phpLoggerAdapterTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mockery::close();
    }

    public function testGetName()
    {
        $logger = Logger::getLogger('foo');
        $wrapper = new Log4phpLoggerAdapter($logger);
        self::assertEquals('foo', $wrapper->getName());
    }

    public function testGetLogger()
    {
        $logger = Logger::getLogger('foo');
        $wrapper = new Log4phpLoggerAdapter($logger);
        self::assertSame($logger, $wrapper->getLog4phpLogger());
    }

    public function testLogs()
    {
        $msg = 'Hello {}!';
        $params = array('World');
        $e = new Exception();

        $logger = Mockery::mock('Logger');
        $logger
            ->shouldReceive('log')
            ->with(LoggerLevel::getLevelDebug(), MessageFormatter::format($msg, $params), $e)
            ->once();
        $logger
            ->shouldReceive('log')
            ->with(LoggerLevel::getLevelInfo(), MessageFormatter::format($msg, $params), $e)
            ->once();
        $logger
            ->shouldReceive('log')
            ->with(LoggerLevel::getLevelWarn(), MessageFormatter::format($msg, $params), $e)
            ->once();
        $logger
            ->shouldReceive('log')
            ->with(LoggerLevel::getLevelError(), MessageFormatter::format($msg, $params), $e)
            ->once();
        $logger
            ->shouldReceive('log')
            ->with(LoggerLevel::getLevelTrace(), MessageFormatter::format($msg, $params), $e)
            ->once();

        $logger
            ->shouldReceive('isDebugEnabled')
            ->withNoArgs()
            ->andReturn(true);
        $logger
            ->shouldReceive('isInfoEnabled')
            ->withNoArgs()
            ->andReturn(true);
        $logger
            ->shouldReceive('isWarnEnabled')
            ->withNoArgs()
            ->andReturn(true);
        $logger
            ->shouldReceive('isTraceEnabled')
            ->withNoArgs()
            ->andReturn(true);
        $logger
            ->shouldReceive('isErrorEnabled')
            ->withNoArgs()
            ->andReturn(true);

        $wrapper = new Log4phpLoggerAdapter($logger);
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

        $logger = Mockery::mock('Logger');
        $logger
            ->shouldReceive('isDebugEnabled')
            ->withNoArgs()
            ->andReturn($debugEnabled);
        $logger
            ->shouldReceive('isInfoEnabled')
            ->withNoArgs()
            ->andReturn($infoEnabled);
        $logger
            ->shouldReceive('isWarnEnabled')
            ->withNoArgs()
            ->andReturn($warnEnabled);
        $logger
            ->shouldReceive('isTraceEnabled')
            ->withNoArgs()
            ->andReturn($traceEnabled);
        $logger
            ->shouldReceive('isErrorEnabled')
            ->withNoArgs()
            ->andReturn($errorEnabled);

        $wrapper = new Log4phpLoggerAdapter($logger);
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
        $wrapper = new Log4phpLoggerAdapter($logger);
        $wrapper->debug('no');
    }
}
