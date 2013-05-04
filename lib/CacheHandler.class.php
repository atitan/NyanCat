<?php

class CacheHandler
{
	public static $priceMTime = '';
	protected $_cacheFile = null;
	protected $_priceFile = null;

	public function __construct()
	{
		$this->_cacheFile = new FileSystem('cache'); //Create new instance
		$this->_priceFile = new FileSystem('price');
		clearstatcache(); //Clear filesystem cache
		static::$priceMTime = $this->_priceFile->getDirTime(); //Get price update time
		// $this->mTime = filemtime( $this->_filehandler );
		// $this->dirTime = date("Y-m-d H:i:s", $this->mTime);
		// $this->gmtTime = gmdate("D, d M Y H:i:s", $this->mTime . " GMT";
	}

	public function checkServerCache()
	{
		if( $this->_filehandler->exists('timeStamp') &&
			$this->_filehandler->exists('valuationOutput') &&
			$this->_filehandler->exists('productCache') &&
			$this->_filehandler->exists('eTag') )
		{
			$timeStamp = $this->_priceFile->getFile('timeStamp');
			$lastUpdateTime = date("Y-m-d H:i:s", static::$priceMTime);
			
			if (strtotime($lastUpdateTime) > strtotime($timeStamp)) {
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
		$lastModifiedTime = gmdate("D, d M Y H:i:s", static::$priceMTime) . " GMT";

		if( isset($_SERVER['HTTP_IF_NONE_MATCH']) ) {
			if ( $_SERVER['HTTP_IF_NONE_MATCH'] == $this->_cacheFile->getFile('eTag') ) {
				return true;
			}
		}
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == $lastModifiedTime) {
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
		$lastModifiedTime = gmdate("D, d M Y H:i:s", static::$priceMTime) . " GMT";
		header("Last-Modified: " . $lastModifiedTime);
		header("ETag: " . $this->_cacheFile->getFile('eTag'));
		readfile($this->_cacheFile . 'valuationOutput');
	}

}