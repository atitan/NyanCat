<?php

class Nyan_Template
{
	public $mode = null;

	public function __construct($mode)
	{
		$this->mode = $mode;
	}

	public function get_header()
	{ 
		require NYAN_DIR_TEMPLATE . 'header.php';
	}

	public function get_upperIndex($mTime)
	{
		echo $mTime;
		require NYAN_DIR_TEMPLATE . 'upperIndex.php';
	}

	public function get_category($category_name, $amountOfProduct, $product)
	{
		static $product_counter = 0;
		
		$parentNode = new DOMDocument();

		foreach ($product as $key => $value) {
			if ($value['price'] == -1) {
				if (isset($optgroupNode)) {
					$parentNode->appendChild($optgroupNode);
				}
				$optgroupNode = $parentNode->createElement('optgroup');
				$optgroupNode->setAttribute('label', $value['name']);
			} else {
				$optionNode = $parentNode->createElement('option', $value['name']);
				$optionNode->setAttribute('data-price', $value['price']);
				$optionNode->setAttribute('value', $product_counter++);
				$optgroupNode->appendChild($optionNode);
			}
		}
 		$parentNode->appendChild($optgroupNode); // assign the last node to Document
 		$category_output = $parentNode->saveHTML();

		require NYAN_DIR_TEMPLATE . 'category.php';
	}

	public function get_lowerIndex($mTime)
	{
		require NYAN_DIR_TEMPLATE . 'lowerIndex.php';
	}

	public function get_footer()
	{
		require NYAN_DIR_TEMPLATE . 'footer.php';
	}
}