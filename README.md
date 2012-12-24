lf4php-log4php
==============

This is a log4php binding for lf4php.

Using lf4php-log4php
--------------------

### Configuration

```php
<?php
Logger::configure('config.xml');
LoggerFactory::setILoggerFactory(new Log4phpLoggerFactory());
```

### Logging

```php
<?php
$logger = LoggerFactory::getLogger('\foo\bar');
$logger->info('Message');
$logger->debug('Hello {{name}}!', array('name' => 'John'));
$logger->error(new \Exception());
```
