<?php

namespace srbot\core;

use ReflectionClass;
use srbot;
use srbot\command\Error;

class Action
{
    private $route;
    private $method = 'index';

    public function __construct($route)
    {
        $route = parse_url($route)['path'];
        $route = strtolower($route);
        $parts = explode('/', preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route));
        $parts = array_map('ucfirst', $parts);

        // Break apart the route
        while ($parts) {
            $file = DIR_COMMAND . ucfirst(implode('/', $parts)) . '.php';

            if (!empty($parts) && is_file($file)) {
                $this->route = implode('/', $parts);
                break;
            } else {
                $this->method = array_pop($parts);
            }
        }
    }

    public function execute($registry)
    {
        // Stop any magical methods being called
        if (substr($this->method, 0, 2) == '__') {
            return (new Error($registry))
                ->send('Calls to magic methods are not allowed!');
        }

        $file = DIR_COMMAND . $this->route . '.php';
        $class = preg_replace('/[^a-zA-Z0-9]/', '', $this->route);

        // Initialize the class
        if (is_file($file)) {
            include_once($file);

            $class = "srbot\\command\\$class";
            $controller = new $class($registry);
        } else {
            return (new Error($registry))
                ->send('Could not call ' . $this->route . '/' . $this->method . '!');
        }

        $reflection = new ReflectionClass($class);

        if ($reflection->hasMethod($this->method)) {
            return call_user_func_array(array($controller, $this->method), []);
        } else {
            return (new Error($registry))
                ->send('Could not call ' . $this->route . '/' . $this->method . '!');
        }
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getMethod()
    {
        return $this->method;
    }
}
