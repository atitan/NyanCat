<?php

class CacheHandler
{
	public $gmtTime = null;
	public $dirTime = null;
	public $mTime = null;
	private $_filehandler = null;

	public function __construct()
	{
		$this->_filehandler = new FileSystem('cache'); //Create new instance
		clearstatcache(); //Clear filesystem cache
		$this->checkServerCache(); //Check server cache at instance startup
		$this->mTime = filemtime( $this->_filehandler );
		$this->dirTime = date("Y-m-d H:i:s", $this->mTime);
		$this->gmtTime = gmdate("D, d M Y H:i:s", $this->mTime . " GMT";
	}

	public function checkServerCache()
	{
		if( $this->_filehandler->exists('timeStamp') &&
			$this->_filehandler->exists('valuationOutput') &&
			$this->_filehandler->exists('productCache') &&
			$this->_filehandler->exists('eTag') )
		{
			$timeStamp = $this->_filehandler->getFile('timeStamp');
			if (strtotime($this->dirTime) > strtotime($timeStamp)) {
				return false;
			} else {
				return true;
			}
		}else{
			return false;
		}
	}

	public function checkClientCache()
	{
		if( isset($_SERVER['HTTP_IF_NONE_MATCH']) ) {
			if ( $_SERVER['HTTP_IF_NONE_MATCH'] == $this->_filehandler->getFile('eTag') ) {
				header("HTTP/1.1 304 Not Modified");
				return true;
			}
		}
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == $lastModifiedTime) {
				header("HTTP/1.1 304 Not Modified");
				return true;
			}
		}
		return false;
	}

	public function saveServerCache()
	{

	}

	public function sendServerCache()
	{
		header("Last-Modified: " . $this->gmtTime);
		header("ETag: " . $this->_filehandler->getFile('eTag'));
		readfile($this->_filehandler . 'valuationOutput');
	}

}