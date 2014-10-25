<?php
/*
 * Copyright (c) 2014 Janos Szurovecz
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

use lf4php\MDC;
use LoggerMDC;
use PHPUnit_Framework_TestCase;

/**
 * Class Log4phpMDCAdapterTest
 *
 * @package lf4php\impl
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class Log4phpMDCAdapterTest extends PHPUnit_Framework_TestCase
{
    const A_KEY = 'key1';
    const A_KEY2 = 'key2';
    const A_VALUE = 'value1';
    const A_VALUE2 = 'value2';

    /**
     * @var Log4phpMDCAdapter
     */
    private $adapter;

    protected function setUp()
    {
        LoggerMDC::clear();
        $this->adapter = new Log4phpMDCAdapter();
    }

    /**
     * @test
     */
    public function shouldBeTheMdcAdapter()
    {
        self::assertInstanceOf('\lf4php\impl\Log4phpMDCAdapter', MDC::getMDCAdapter());
    }

    /**
     * @test
     */
    public function shouldPutWork()
    {
        $this->adapter->put(self::A_KEY, self::A_VALUE);
        self::assertEquals(self::A_VALUE, LoggerMDC::get(self::A_KEY));
    }

    /**
     * @test
     */
    public function shouldGetWork()
    {
        LoggerMDC::put(self::A_KEY, self::A_VALUE);
        self::assertEquals(self::A_VALUE, $this->adapter->get(self::A_KEY));
    }

    /**
     * @test
     */
    public function shouldRemoveWork()
    {
        LoggerMDC::put(self::A_KEY, self::A_VALUE);
        $this->adapter->remove(self::A_KEY);
        self::assertNull($this->adapter->get(self::A_KEY));
    }

    /**
     * @test
     */
    public function shouldClearWork()
    {
        LoggerMDC::put(self::A_KEY, self::A_VALUE);
        LoggerMDC::put(self::A_KEY2, self::A_VALUE2);
        $this->adapter->clear();
        self::assertNull($this->adapter->get(self::A_KEY));
        self::assertNull($this->adapter->get(self::A_KEY2));
    }

    /**
     * @test
     */
    public function shouldGetCopyOfContextWork()
    {
        LoggerMDC::put(self::A_KEY, self::A_VALUE);
        LoggerMDC::put(self::A_KEY2, self::A_VALUE2);
        $result = $this->adapter->getCopyOfContextMap();
        self::assertEquals(self::A_VALUE, $result[self::A_KEY]);
        self::assertEquals(self::A_VALUE2, $result[self::A_KEY2]);
    }

    /**
     * @test
     */
    public function shouldSetContextMapWork()
    {
        $this->adapter->setContextMap(
            array(
                self::A_KEY => self::A_VALUE,
                self::A_KEY2 => self::A_VALUE2
            )
        );
        $result = $this->adapter->getCopyOfContextMap();
        self::assertEquals(self::A_VALUE, $result[self::A_KEY]);
        self::assertEquals(self::A_VALUE2, $result[self::A_KEY2]);
    }
}
