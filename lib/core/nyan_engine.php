<?php

class Nyan_Engine
{
    public $mode = null;

    public function __construct($mode)
    {
        $this->mode = $mode;
    }

    public function run() // running mode selector
    {
        if ($this->mode == 'index') {
            $this->run_index();
        } else if ($this->mode == 'checkout') {
            $this->run_checkout();
        } else if ($this->mode == 'show') {
            $this->run_show();
        } else {
            throw new Exception('Undefined running mode.');
        }
    }

    protected function run_index() // index mode executor
    {
        require NYAN_DIR_CORE . 'nyan_cache.php';
        $cache = new Nyan_Cache();

        if ($cache->check_validity()) { // check cache
            $cache->output();
            exit();
        }

        ob_start(); // start recording output for cache
        require NYAN_DIR_CORE . 'nyan_generator.php'; // load generator
        $gen = new Nyan_Generator($this->mode);
        $gen->generate_index($cache); // start generating content
        $cache->save_cache('valuationOutput', ob_get_contents()); // save output content
        $cache->save_cache('eTag', md5(ob_get_contents())); // compute and save eTag
        $cache->save_timeStamp();

        $cache->send_http_header(); // set http header before send content
        ob_end_flush(); // flush buffer and ready to end
    }

    protected function run_checkout() // checkout mode executor
    {
        require NYAN_DIR_CORE . 'nyan_cache.php';
        $cache = new Nyan_Cache();

        if (!$cache->check_validity() || !$cache->check_page_validity()) {
            throw new Exception('報價已過期');
        }

        if (!isset($_POST['product']) || !isset($_POST['quantity'])) {
            throw new Exception("未送出報價內容。");
        }

        $productCache = unserialize($cache->fetch_cache('productCache'));

        require NYAN_DIR_CORE . 'nyan_generator.php'; // load generator
        $gen = new Nyan_Generator($this->mode);
        $serial = $gen->generate_checkout($productCache);

        header('Location: show.php?serial=' . $serial);
    }

    protected function run_show() // show mode executor
    {
        $serial = $_GET['serial'];

        if (!preg_match('/^[0-9A-Z]{8}$/', $serial)) {
            throw new Exception("報價單編號格式不正確！");
        }

        require NYAN_DIR_CORE . 'nyan_generator.php'; // load generator
        $gen = new Nyan_Generator($this->mode);

        $gen->generate_show($serial);
    }
}