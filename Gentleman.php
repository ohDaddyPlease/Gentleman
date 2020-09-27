<?php

namespace Gentleman;

require __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
require __DIR__. DIRECTORY_SEPARATOR . 'functions.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Dotenv\Dotenv;
use InvalidArgumentException;

class Gentleman
{

    /** @var Logger logger */
    public static $logger;

    private function __construct(){}

    public static function configurate()
    {
        define('CONFIGURATION_NAME', 'configuration');
        define('CONFIGURATION_LOG_PATH', __DIR__ . DIRECTORY_SEPARATOR . CONFIGURATION_NAME . '.log');

        $configurationLog = new Logger(CONFIGURATION_NAME);
        $configurationLog->pushHandler(new StreamHandler(CONFIGURATION_LOG_PATH, Logger::INFO));

        define('ENV_FILE', '.env');
        if (!is_file(ENV_FILE))
        {
            generateEnvFile();
            $configurationLog->warning('.env файл не найден и будет сгенерирован ...');
            throw new InvalidArgumentException('.env файл не найден и будет сгенерирован ...');
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
            $configurationLog->warning('Не установлен параметр APP_NAME');
            throw new InvalidArgumentException('Не установлен параметр APP_NAME');
        }

        $configurationLog->close();
    }
}