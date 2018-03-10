<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use lf4php\LoggerFactory;
use lf4php\MDC;

Logger::configure(
    array(
        'rootLogger' => array(
            'appenders' => array('default'),
        ),
        'appenders' => array(
            'default' => array(
                'class' => 'LoggerAppenderConsole',
                'layout' => array(
                    'class' => 'LoggerLayoutPattern',
                    'params' => array(
                        'conversionPattern' => '%date %p [%mdc{IP}] %logger{20} %l %message%newline%ex'
                    )
                )
            )
        )
    )
);

$logger = LoggerFactory::getLogger('foo\bar');
MDC::put('IP', '127.0.0.1');
$logger->info('Hello {}!', array('World'));
$logger->error(new Exception());
Test::run();

class Test
{
    public static function run()
    {
        LoggerFactory::getLogger(Test::class)->error('Logging from class', null, new Exception('class exp'));
    }
}
