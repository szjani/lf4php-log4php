lf4php-log4php
==============

This is a log4php binding for lf4php.

Using lf4php-log4php
--------------------

### Log4php configuration

```php
<?php
Logger::configure('config.xml');
```

lf4php will work properly without any configuration steps. 

### Logging

```php
<?php
$logger = LoggerFactory::getLogger(__CLASS__);
$logger->info('Message');
$logger->debug('Hello {}!', array('John'));
$logger->error(new \Exception());
```

History
-------

### 2.1

MDC support.

### 2.0

Updated lf4php (3.0.x)