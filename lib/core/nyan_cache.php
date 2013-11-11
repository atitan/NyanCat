<?php 

class Nyan_Cache
{
	public $mTime = false;
	public $timeStamp = false;
	public $lastModifiedTime = false;

	public function check_validity()
	{
		if (!$this->check_files()) {
			return false;
		}
		if (!$this->check_timestamp()) {
			return false;
		}

		return true;
	}

	public function check_timestamp()
	{
		if (!$this->mTime = filemtime(NYAN_DIR_PRICES) ||
			!$this->timeStamp = file_get_contents(NYAN_DIR_CACHE.'timeStamp')) {
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

	public function save_cache($name, $content)
	{
		file_put_contents(NYAN_DIR_CACHE . $name, $content);
	}

	public function save_timestamp()
	{
		file_put_contents(NYAN_DIR_CACHE . 'timeStamp', $this->mTime);
	}

	public function check_http_header()
	{
		if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && file_exists(NYAN_DIR_CACHE . 'eTag')) {
			if ($_SERVER['HTTP_IF_NONE_MATCH'] == file_get_contents(NYAN_DIR_CACHE . 'eTag')) {
				return true;
			}
		}
		$this->lastModifiedTime = gmdate("D, d M Y H:i:s \G\M\T", $this->mTime);
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == $this->lastModifiedTime) {
				return true;
			}
		}

		return false;
	}

	public function send_http_header()
	{

	}

	public function output()
	{
		if ($this->check_http_header()) { // exit immediately if user cache matched
			header("HTTP/1.1 304 Not Modified");
			die();
		}

		header("Last-Modified: " . $this->lastModifiedTime);
		if ($eTag = file_get_contents(NYAN_DIR_CACHE . 'eTag')) {
			header("ETag: " . $eTag);
		}
		if (readfile(NYAN_DIR_CACHE . 'valuationOutput') == false) {
			throw new Exception('快取出錯，請重新整理！');
		}
	}
}