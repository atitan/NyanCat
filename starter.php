<?php

/* load configuration */
require './config.php';

/* define needed constant */
define("NYAN_VERSION", "2.0");
define("NYAN_DIR_ROOT", dirname(__file__));
define("NYAN_DIR_CACHE", NYAN_DIR_ROOT . '/cache/');
define("NYAN_DIR_PRICES", NYAN_DIR_ROOT . '/prices/');
define("NYAN_DIR_VALUATIONS", NYAN_DIR_ROOT . '/valuations/');
define("NYAN_DIR_CORE", NYAN_DIR_ROOT . '/lib/core/');
define("NYAN_DIR_TEMPLATE", NYAN_DIR_ROOT . '/lib/template/');

/* check if directory is writable */
if (!is_writable(NYAN_DIR_CACHE)) {
	throw new Exception('快取目錄無法寫入');
}
if (!is_writable(NYAN_DIR_VALUATIONS)) {
	throw new Exception('報價目錄無法寫入');
}

/* load nyan core engine */
require NYAN_DIR_CORE . 'nyan_engine.php';