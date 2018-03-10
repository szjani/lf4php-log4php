<?php
declare(strict_types=1);

namespace lf4php\impl;

use lf4php\LoggerFactory;
use PHPUnit\Framework\TestCase;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class Log4phpLoggerFactoryTest extends TestCase
{
    public function testGetLogger()
    {
        $fooBar1Logger = LoggerFactory::getLogger('\foo\bar');
        $fooBar2Logger = LoggerFactory::getLogger('foo.bar');
        self::assertSame($fooBar1Logger, $fooBar2Logger);
        self::assertEquals('foo.bar', $fooBar1Logger->getLog4PhpLogger()->getName());
    }
}
