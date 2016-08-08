<?php

require_once dirname(__DIR__) . '/vendor' . '/autoload.php';
require_once dirname(__DIR__) . '/conf' . '/api.conf.public.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('NFe-log');
$log->pushHandler(new StreamHandler(dirname(__DIR__) . '/log/nfe.error.log', Logger::ERROR));
$log->pushHandler(new StreamHandler(dirname(__DIR__) . '/log/nfe.info', Logger::INFO));
//\NFe\Registry::set('log', $log);