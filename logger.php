<?php
// logger.php

require_once __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Processor\IntrospectionProcessor;

// Create logs folder if not exists
$logDir = __DIR__ . '/logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0777, true);
}

// Create logger
$logger = new Logger('TrainingSystem');

// Add processor to capture file and line number
$logger->pushProcessor(new IntrospectionProcessor());

// Log format
$dateFormat = "Y-m-d H:i:s";
$output = "[%datetime%] %extra.file%:%extra.line% %channel%.%level_name%: %message% %context%\n";
$formatter = new LineFormatter($output, $dateFormat, true, true);

// Log file (daily)
$logFile = $logDir . '/app-' . date('Y-m-d') . '.log';
$handler = new StreamHandler($logFile, Logger::DEBUG);
$handler->setFormatter($formatter);

$logger->pushHandler($handler);

// TEST LOG
$logger->info("Logger initialized successfully");

return $logger;