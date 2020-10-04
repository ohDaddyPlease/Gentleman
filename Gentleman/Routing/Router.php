<?php

namespace Gentleman\Routing;

class Router
{
    /** @var string входной файл из папки app */
    private static $startPoint;

    public static function registerStartPoint(string $point): void
    {
        self::$startPoint = 'app' . DIRECTORY_SEPARATOR . $point;

        if (!is_file(self::$startPoint)) {
            $notFoundFilePath = 'app' . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . '404.php';
            self::$startPoint = is_file($notFoundFilePath) ? $notFoundFilePath : generate404();
        }
    }

    public static function resolveRoute()
    {
        $path = explode('/', trim($_SERVER['PATH_INFO'], '/'));

        self::registerStartPoint($path[0] ? $path[0] . '.php' : START_POINT);

        require_once self::$startPoint;
    }

}