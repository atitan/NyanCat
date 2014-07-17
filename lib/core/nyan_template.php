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
		require NYAN_DIR_TEMPLATE . 'upperIndex.php';
	}

	public function get_category($category_name, $amountOfProduct, $product)
	{
		static $product_counter = 0;
		
		$parentNode = new DOMDocument();

		foreach ($product as $key => $value) {
			if ($value['price'] == -1) {
				if(isset($optgroupNode)) { 
					$parentNode->appendChild($optgroupNode); 
				}
				$optgroupNode = $parentNode->createElement('optgroup');
				$optgroupNode->setAttribute('label', $value['name']);
			} else {
				$optionNode = $parentNode->createElement('option', $value['name'].' - $'.$value['price']);
				$optionNode->setAttribute('data-price', $value['price']);
				$optionNode->setAttribute('value', $product_counter++);
				if(isset($optgroupNode)) { // 第一筆資料為直接為商品時會發生問題，要判定是否有 Group 來決定直接放進去還是放到 Group
          			$optgroupNode->appendChild($optionNode);
        		} else {
          			$parentNode->appendChild($optionNode);
        		}
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

	public function get_valuation($valuation, $total)
	{
		$parentNode = new DOMDocument();

		foreach ($valuation as $key => $value) {
			$tr = $parentNode->createElement('tr');

			$tr->appendChild($parentNode->createElement('td', $key));
			$tr->appendChild($parentNode->createElement('td', $value['price']));
			$tr->appendChild($parentNode->createElement('td', $value['quantity']));
			$tr->appendChild($parentNode->createElement('td', $value['subtotal']));

			$parentNode->appendChild($tr);
		}

		$valuation_output = $parentNode->saveHTML();

		require NYAN_DIR_TEMPLATE . 'valuation.php';
	}

	public function show_valuation($content)
	{
		require NYAN_DIR_TEMPLATE . 'show.php';
	}

	public function get_footer()
	{
		require NYAN_DIR_TEMPLATE . 'footer.php';
	}
}