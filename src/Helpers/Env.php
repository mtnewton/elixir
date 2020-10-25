<?php

namespace MTNewton\Elixir\Helpers;

class Env
{
    protected $env = [];

    protected static $instance;

    protected function __construct()
    {
        $this->loadEnv();
        self::$instance = $this;
    }

    public static function getInstance()
    {
        return self::$instance ?? new self();
    }

    protected function loadEnv()
    {
        $env = require __DIR__ . '/../Config/env.php';
        $this->setEnv('', $env);
    }

    protected function setEnv(string $key, $value)
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $this->setEnv($key ? "{$key}.{$k}" : $k, $v);
            }
            return;
        }
        $this->env[$key] = $value;
    }

    public static function get(string $key, $default = null)
    {
        return self::getInstance()->env[$key] ?? $default;
    }
}
