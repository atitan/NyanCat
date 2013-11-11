<?php

class Nyan_Generator
{
	public $mode = null;

	public function __construct($mode)
	{
		$this->mode = $mode;
	}

	public function generate_index($cacheObj)
	{
		require NYAN_DIR_CORE . 'nyan_template.php'; // load template engine
		$template = new Nyan_Template($this->mode);

		$template->get_header(); // get html head
		$template->get_upperIndex($cacheObj->mTime); // get body header

		$file_list = glob(NYAN_DIR_PRICES . '*.[tT][xX][tT]'); // read file list from system
		for ($i = 0; $i < count($file_list); $i ++) { // loop through files
			$fileBuffer = file($file_list[$i], FILE_IGNORE_NEW_LINES); // read file
			list($products, $amountOfProduct, $productCache) = $this->parse_priceFile($fileBuffer); // parse and split
			
			$category_name = $this->get_categoryName($file_list[$i]);
			$template->get_category($category_name, $amountOfProduct, $products);
		}
		$cacheObj->save_cache('productCache', serialize($productCache));

		$template->get_lowerIndex($cacheObj->mTime);
		$template->get_footer();
	}

	public function generate_checkout()
	{

	}

	public function generate_show()
	{

	}

	public function parse_priceFile($fileBuffer)
	{
		$amountOfProduct = 0;
		for ($i = 0; $i < count($fileBuffer); $i++) { 
			preg_match("/([^,]*),?([^,]*)/", $fileBuffer[$i], $matches);

			if ($matches[2] != '') { // check if price exists in line
				$products[] = array(
					'name' => htmlspecialchars(trim($matches[1])),
					'price' => intval(trim($matches[2]))
				);
				$amountOfProduct++;

				$productCache[] = array( // store parsed data for later use
					'products' => htmlspecialchars(trim($matches[1])),
					'prices' =>  trim(intval($matches[2]))
				);
			} else {
				$products[] = array(
					'name' => htmlspecialchars(trim($matches[1])),
					'price' => -1
				);
			}
		}

		return array($products, $amountOfProduct, $productCache);
	}

	public function get_categoryName($source)
	{
		// get rid of .txt
		preg_match("/(.*)\/(.*).(txt|TXT)/", $source, $matches);
		$source = $matches[2];

    	// detect the character encoding of the incoming file
    	$encoding = mb_detect_encoding( $source, "auto" );
       
    	// escape all of the question marks so we can remove artifacts from
    	// the unicode conversion process
    	$target = str_replace( "?", "[question_mark]", $source );
       
    	// convert the string to the target encoding
    	$target = mb_convert_encoding( $target, "UTF-8", $encoding);
       
    	// remove any question marks that have been introduced because of illegal characters
    	$target = str_replace( "?", "", $target );
       
    	// replace the token string "[question_mark]" with the symbol "?"
    	$target = str_replace( "[question_mark]", "?", $target );
   
    	return $target;
	}
}