<?php 

class Nyan_Cache
{
	public $mTime = false;
	public $timeStamp = false;
	public $lastModifiedTime = false;

	public function __construct()
	{
		$this->mTime = filemtime(NYAN_DIR_PRICES);
		$this->lastModifiedTime = gmdate("D, d M Y H:i:s \G\M\T", $this->mTime);
	}

	public function check_validity()
	{
		if (!$this->check_files() || !$this->check_timestamp()) {
			return false;
		}

		return true;
	}

	public function check_page_validity()
	{
		if (!isset($_POST['cache-validator'])) {
			return false;
		}

		if (md5($this->$mTime) != $_POST['cache-validator']) {
			return false;
		}

		return true;
	}

	public function check_timestamp()
	{
		if (!$this->timeStamp = file_get_contents(NYAN_DIR_CACHE . 'timeStamp')) {
			return false;
		}
		if ($this->mTime > $this->timeStamp) {
			return false;
		}

		return true;
	}

	public function check_files()
	{
		if (!file_exists(NYAN_DIR_CACHE . 'timeStamp') ||
			!file_exists(NYAN_DIR_CACHE . 'valuationOutput') ||
			!file_exists(NYAN_DIR_CACHE . 'productCache') ||
			!file_exists(NYAN_DIR_CACHE . 'eTag')) {
			return false;
		}
					
		return true;
	}

	public function fetch_cache($name)
	{
		$content = file_get_contents(NYAN_DIR_CACHE . $name);

		if ($content === false) {
			throw new Exception("快取出錯，請重新整理！");
		}

		return $content;
	}

	public function save_cache($name, $content)
	{
		if (file_put_contents(NYAN_DIR_CACHE . $name, $content) === false) {
			throw new Exception("無法寫入快取！");
		}
	}

	public function save_timestamp()
	{
		if (file_put_contents(NYAN_DIR_CACHE . 'timeStamp', $this->mTime) === false) {
			throw new Exception("無法寫入快取！");
		}
	}

	public function check_http_header()
	{
		if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && file_exists(NYAN_DIR_CACHE . 'eTag')) {
			if ($_SERVER['HTTP_IF_NONE_MATCH'] == file_get_contents(NYAN_DIR_CACHE . 'eTag')) {
				return true;
			}
		}
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == $this->lastModifiedTime) {
				return true;
			}
		}

		return false;
	}

	public function send_http_header()
	{
		header("Last-Modified: " . $this->lastModifiedTime);
		if ($eTag = file_get_contents(NYAN_DIR_CACHE . 'eTag')) {
			header("ETag: " . $eTag);
		}
	}

	public function output()
	{
		if ($this->check_http_header()) { // exit immediately if user cache matched
			header("HTTP/1.1 304 Not Modified");
			die();
		}

		$this->send_http_header();

		if (readfile(NYAN_DIR_CACHE . 'valuationOutput') == false) {
			throw new Exception('快取出錯，請重新整理！');
		}
	}
}