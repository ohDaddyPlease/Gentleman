<?php

define('ROOT_PATH', realpath(dirname(__DIR__ . '/../../../')));

define('APP_PATH', realpath(dirname(ROOT_PATH . '/app')));

define('GENTLEMAN_PATH', realpath(dirname(ROOT_PATH . '/Gentleman')));

define('CONFIGURATION_LOG_PATH',
    ROOT_PATH . '/logs/configuration.log'
);

define('ENV_FILE_NAME', ROOT_PATH . '/.env');

define('APP_LOG_PATH', ROOT_PATH . '/logs/' . APP_NAME . '.log');
