<?php
declare(strict_types=1);

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
    public function getLogger(string $name) : \lf4php\Logger
    {
        return $this->map->$name;
    }
}
