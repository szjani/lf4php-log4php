<?php
declare(strict_types=1);

namespace lf4php\impl;

use lf4php\spi\MDCAdapter;
use LoggerMDC;

/**
 * {@link MDCAdapter} implementation for log4php.
 *
 * @package lf4php\impl
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class Log4phpMDCAdapter implements MDCAdapter
{
    /**
     * @param string $key
     * @param string $value
     */
    public function put(string $key, string $value) : void
    {
        LoggerMDC::put($key, $value);
    }

    /**
     * @param string $key
     * @return string
     */
    public function get(string $key) : ?string
    {
        $result = LoggerMDC::get($key);
        return $result === '' ? null : $result;
    }

    /**
     * @param string $key
     */
    public function remove(string $key) : void
    {
        LoggerMDC::remove($key);
    }

    public function clear() : void
    {
        LoggerMDC::clear();
    }

    /**
     * @return array|null
     */
    public function getCopyOfContextMap() : ?array
    {
        return LoggerMDC::getMap();
    }

    /**
     * @param array $contextMap
     */
    public function setContextMap(array $contextMap) : void
    {
        foreach ($contextMap as $key => $value) {
            $this->put($key, $value);
        }
    }
}
