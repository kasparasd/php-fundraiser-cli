<?php

namespace src;

abstract class Config
{
    protected array $config;
    public function __construct($env)
    {
        $this->config = parse_ini_file($env);
    }

    public function getItem($name)
    {
        return $this->config[$name];
    }
}
