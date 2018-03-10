<?php
declare(strict_types=1);

namespace lf4php\impl;

/**
 * StaticMDCBinder for log4php.
 *
 * @see \lf4php\MDC
 * @package lf4php\impl
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
final class StaticMDCBinder
{
    /**
     * @var StaticMDCBinder
     */
    public static $SINGLETON;

    private function __construct()
    {
    }

    public static function init() : void
    {
        self::$SINGLETON = new self();
    }

    public function getMDCA() : Log4phpMDCAdapter
    {
        return new Log4phpMDCAdapter();
    }
}
StaticMDCBinder::init();
