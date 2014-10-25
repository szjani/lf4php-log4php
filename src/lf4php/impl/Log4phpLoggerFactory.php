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

use LazyMap\CallbackLazyMap;
use lf4php\ILoggerFactory;
use Logger;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class Log4phpLoggerFactory implements ILoggerFactory
{
    /**
     * Should not be used directly. It is public due to PHP 5.3 compatibility.
     *
     * @var CallbackLazyMap
     */
    public $map;

    public function __construct()
    {
        $self = $this;
        $this->map = new CallbackLazyMap(
            function ($name) use ($self) {
                $filteredName = str_replace('\\', '.', trim($name, '\\'));
                return $filteredName === $name
                    ? new Log4phpLoggerAdapter(Logger::getLogger($name))
                    : $self->map->$filteredName;
            }
        );
    }

    /**
     * $name can be an FQCN, it follows log4php parent-child conventions.
     *
     * @param string $name
     * @return \lf4php\Logger
     */
    public function getLogger($name)
    {
        return $this->map->$name;
    }
}
