<?php

namespace src;

abstract class Model
{
    protected DB $db;
    public function __construct()
    {
        $this->db = App::db();
    }
}
