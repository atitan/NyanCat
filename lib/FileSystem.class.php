<?php

class FileSystem
{
	private $_base_dir = dirname(__file__) . '/'; //設定路徑變數
	private $_curr_dir = '';

	public function __construct($dir)
	{
		if( substr($dir, -1) != '/' ){
			$dir .= '/';
		}
		$this->_curr_dir = $_base_dir . $dir;
	}

	public function exists($filename)
	{
		return file_exists($this->_curr_dir . $filename);
	}

	public function getFile($filename)
	{
		return file_get_contents($this->_curr_dir . $filename);
	}

	public function saveFile($filename)
	{

	}

	public function getDirList()
	{
		if ($handle = opendir($this->_curr_dir)) {
    		while (false !== ($entry = readdir($handle))) {
        		if ($entry != "." && $entry != "..") {
            		$files[] = $entry;
        		}
    		}
    		if ($ptr < 1) {
				die('找不到報價檔！');
			}
    		closedir($handle);
		}
		return $files; //return array
	}

	public function getFileLineByLine($filename)
	{
		return file($this->_curr_dir . $filename, FILE_IGNORE_NEW_LINES); //return array
	}

	public function __toString()
	{
		return $this->_curr_dir;
	}
}