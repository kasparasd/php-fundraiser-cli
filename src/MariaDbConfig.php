<?php

namespace src;

class MariaDbConfig extends Config
{
    public function __construct($env)
    {
        parent::__construct($env);
    }

    public function mariaDbConfig()
    {
        $config = [
            'host' => $this->getItem('DB_HOST'),
            'database' => $this->getItem('DB_DATABASE'),
            'user' => $this->getItem('DB_USER'),
            'password' => $this->getItem('DB_PASS'),
        ];

        return $config;
    }
}
