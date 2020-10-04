<?php

namespace Gentleman;

require __DIR__. DIRECTORY_SEPARATOR . 'functions.php';

use Gentleman\Routing\Router;
use Gentleman\Logging\Logger;

use Symfony\Component\Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;

use RuntimeException;

class Gentleman
{

    /** @var Logger logger */
    public static $logger;

    /** @var int был ли вызван метод configure */
    private static $configured = 0;

    private function __construct(){}

    public static function configure(): void
    {
        define('CONFIGURATION_NAME', 'configuration');
        define('CONFIGURATION_LOG_PATH',
               'logs' . DIRECTORY_SEPARATOR . CONFIGURATION_NAME . '.log'
        );

        $configurationLog = new Logger(CONFIGURATION_NAME);
        $configurationLog->pushHandler(new StreamHandler(CONFIGURATION_LOG_PATH, Logger::INFO));

        if (self::$configured) {
            $configurationLogMessage = 'Первоначальная конфигурация уже была совершена, используйте специальные методы для тонкой настройки';
            $configurationLog->error($configurationLogMessage);
            throw new RuntimeException($configurationLogMessage);
        }

        define('ENV_FILE', '.env');
        if (!is_file(ENV_FILE))
        {
            $envFileLogMessage = '.env файл не найден и будет сгенерирован ...';
            generateEnvFile();
            $configurationLog->warning($envFileLogMessage);
        }

        $dotenv = new Dotenv();
        $dotenv->load(ENV_FILE);

        define('APP_NAME', $_ENV['APP_NAME'] ?? 'dev');
        define('START_POINT', $_ENV['START_POINT'] ?? 'index.php');
        define('APP_LOG_PATH', 'logs' . DIRECTORY_SEPARATOR . APP_NAME . '.log');
        self::$logger = (new Logger(APP_NAME))->pushHandler(
            new StreamHandler(APP_LOG_PATH, Logger::INFO)
        );

        $configurationLog->close();
        self::$configured = 1;

        /*
        * Errors
        */
        $errorsHandler = static function ($code, $description) {
            self::$logger->warning($description);
        };
        set_error_handler($errorsHandler);

        $exceptionsHandler = static function ($e) {
            self::$logger->error(
                'Message: '. $e->getMessage() . PHP_EOL .
                'File: ' . $e->getFile() . PHP_EOL .
                'Line: ' . $e->getLine() . PHP_EOL .
                'Trace: ' . $e->getTraceAsString() . PHP_EOL
            );

            throw $e;
        };
        set_exception_handler($exceptionsHandler);
    }

    public static function run(): void
    {
        Router::resolveRoute();
    }
}