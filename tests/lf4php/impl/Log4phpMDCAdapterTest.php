<?php
declare(strict_types=1);

namespace lf4php\impl;

use lf4php\MDC;
use LoggerMDC;
use PHPUnit\Framework\TestCase;

/**
 * Class Log4phpMDCAdapterTest
 *
 * @package lf4php\impl
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class Log4phpMDCAdapterTest extends TestCase
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
