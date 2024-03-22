<?php

namespace src;

abstract class Config
{
    protected array $config;
    public function __construct()
    {
        $this->config = parse_ini_file(ENV);
    }

    public function getItem($name)
    {
        return $this->config[$name];
    }
}
