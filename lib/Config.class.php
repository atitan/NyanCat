<?php

class Config
{
	private static $_configFile = null;

	private function __construct()
    {}

    private function __clone()
    {}

    public static function getConfig()
    {
    	if (static::$_configFile === null
            || !(static::$_configFile instanceof static)) {
            static::$_configFile = new FileSystem('config');
        }
        return static::$_instance;
    }

}

public static function getInstance()
    {
        if (static::$_instance === null
            || !(static::$_instance instanceof static)) {
            static::$_instance = new static();
        }
        return static::$_instance;
    }