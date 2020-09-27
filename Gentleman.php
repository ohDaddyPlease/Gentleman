<?php

namespace Gentleman;

require __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
require __DIR__. DIRECTORY_SEPARATOR . 'functions.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use RuntimeException;
use Symfony\Component\Dotenv\Dotenv;
use InvalidArgumentException;

class Gentleman
{

    /** @var Logger logger */
    public static $logger;

    /** @var int был ли вызван метод configure */
    private static $configured = 0;

    private function __construct(){}

    public static function configure()
    {
        define('CONFIGURATION_NAME', 'configuration');
        define('CONFIGURATION_LOG_PATH', __DIR__ . DIRECTORY_SEPARATOR . CONFIGURATION_NAME . '.log');

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
            throw new InvalidArgumentException($envFileLogMessage);
        }

        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . DIRECTORY_SEPARATOR . ENV_FILE);

        if (isset($_ENV['APP_NAME']) && !empty($_ENV['APP_NAME'])) {
            define('APP_NAME', $_ENV['APP_NAME']);
            define('APP_LOG_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . APP_NAME . '.log');
            self::$logger = (new Logger(APP_NAME))->pushHandler(
                new StreamHandler(APP_LOG_PATH, Logger::INFO)
            );
        } else {
            $appNameLogMessage = 'Не установлен параметр APP_NAME';
            $configurationLog->error($appNameLogMessage);
            throw new InvalidArgumentException($appNameLogMessage);
        }

        $configurationLog->close();
        self::$configured = 1;
    }
}