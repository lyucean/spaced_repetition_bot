<?php


namespace srbot\core;

/**
 * Class Routing
 * @package srbot\core
 * @example https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
 * @example https://github.com/steampixel/simplePHPRouter/tree/master
 */
class Routing
{
    const BASE_DIR = '../command/';

    public function index($class, $arg)
    {
        // If it's a callback, we'll redirect it to the last command.


        // If it's an independent command.
        if (mb_substr($text, 0, 1, 'UTF-8') == '/') {
        }
        // This is command or callback
        if ($this->telegram->getUpdateType() == 'callback_query') {
            // Get the last command called

            return;

            return;
        } else {
        }
//
//                $fn = 'pages/admin.php';
//
//                if (file_exists($fn))
//                    reqiure($fn);
//                else
//                    reqiure('pages/404.php');

    }

    /**
     * If a file exists, require it from the file system.
     *
     * @param string $file The file to require.
     * @return bool True if the file exists, false if not.
     */
    public function requireFile($file)
    {
        $path = self::BASE_DIR . $file . '.php';

        if (file_exists($path)) {
            require $path;
            return true;
        }
        return false;
    }
}
