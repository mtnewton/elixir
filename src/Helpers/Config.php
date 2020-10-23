<?php

namespace MTNewton\Elixir\Helpers;

class Config
{
    protected $config = [];

    protected static $instance;

    protected function __construct()
    {
        $this->loadConfig();
        self::$instance = $this;
    }

    public static function getInstance() 
    {
        return self::$instance ?? new self();
    }

    protected function loadConfig()
    {
        $config = require __DIR__.'/../config.php';
        $this->set('', $config);
    }

    protected function set(string $key, $value) 
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $this->set($key ? "{$key}.{$k}" : $k, $v);
            }
            return;
        }
        $this->config[$key] = $value;
    }

    public static function get(string $key, $default = null)
    {
        return self::getInstance()->config[$key] ?? $default;
    }
}
