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
		} else {
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
	}

	protected function run_checkout() // checkout mode executor
	{

	}

	protected function run_show() // show mode executor
	{

	}
}