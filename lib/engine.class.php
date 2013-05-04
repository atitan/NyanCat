<?php

class contentEngine
{
	public $valuationOutput = '';
	private $_prices_handler = null;
	private $_validProductList = [];

	public function __construct()
	{
		$this->_prices_handler = new FileSystem('prices');
	}

	public function generateValuation() //產生估價頁面
	{
		$fileList = $this->_prices_handler->getDirList(); //取得報價資料夾列表

		for($i = 0; $i < count($fileList); $i++)
		{
			$this->priceParser( $fileList[$i] );
		}
	}

	private function priceParser($filename) //分離行列中的產品與價格
	{
		$fileContent = $this->_prices_handler->getFileLineByLine( $fileList[$i] ); //讀取單檔內容
		
		for ($i = 0; $i < count($fileContent); $i++) //掃描檔案，將產品名稱與價格分離
		{ 
			$commaPos = strrpos($fileContent[$i], ","); //確認行列是否含有逗號
			if ($commaPos > 0) { 
				$productInfo[$i]['name'] = htmlspecialchars(trim(substr($fileContent[$i], 0, $commaPos)));
				$productInfo[$i]['price'] =  substr($fileContent[$i], ($commaPos + 1), strlen($fileContent[$i]));
				$this->_validProductList[] = [
					'name' => $productInfo[$i]['name'],
					'price' => $productInfo[$i]['price'],
				];
			} else {
				$productInfo[$i]['name'] = htmlspecialchars(trim($fileContent[$i]));
				$productInfo[$i]['price'] = -1; //用來判別是否為有效產品
			}
		}

		return $productInfo;
	}
}

$valuationOutput = '<!DOCTYPE html><html dir="ltr" lang="zh-TW"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><title>'.SITENAME.'</title><meta name="author" content="Skyarrow &amp; ATI"><meta name="generator" content="Super NyanCat v'.NYAN_VERSION.'"><link rel="stylesheet" href="css/index.css"><!--[if lt IE 10]><link rel="stylesheet" href="css/fuckyouie.css"><![endif]--><script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script><!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]--></head><body><header id="header"><h1>'.SITENAME.'</h1><p>項目未列出≠我們就沒有，打※號產品為非常備庫存<br>歡迎來電洽詢或於估價單中備註您的需求，謝謝！<br><br><strong>報價最後更新：'.$mTime.'</strong></p></header><form action="'.CHECKOUT.'" method="post" accept-charset="utf-8" target="_blank"><noscript class="nojs">您的瀏覽器不支援 Javascript。<br>沒關係！只要選取品項和輸入數量，您一樣可以估價！報價將在送出後顯示！</noscript><table class="list"><tr><th></th><th>商品項目</th><th>單價</th><th>數量</th><th>小計</th></tr>'; //淨空字串
			

		for ($p = 2; $p < $ptr; $p++) { //獲取檔案內容
			

			$category = htmlspecialchars(iconv("big5","UTF-8",substr($files[$p], 0, -4)));

			$valuationOutput .= '<tr class="item">'.
								'<td><a class="add-item" href="javascript:void(0)" title="新增"></a><a class="remove-item" href="javascript:void(0)" title="移除"></a></td>'.
								'<td>'.
								'<div class="selectbox"><select class="product" name="product[]">'.
								'<option>'.$category.'  --  共計'.$amountOfProduct.'樣 (尚未選擇) </option>';

			$tagEnded = false;
			for ($i = 0; $i < $bufferLength; $i++) {
				if ($value[$i] == '0' && $tagEnded == true) {
					$valuationOutput .= '</optgroup>';
					$tagEnded = false;
				}
				if ($value[$i] == '0') {
					$valuationOutput .= '<optgroup label="'.$products[$i].'">';
					$tagEnded = true;
				} else {
					if (!isset($productID)) {
						$productID = 0;
					} else {
						$productID++;
					}
					$valuationOutput .= '<option data-price="'.$value[$i].'" value="'.$productID.'">'.$products[$i].' - $'.$value[$i].'</option>';
				}
				if ($tagEnded == true && ($i+1) == $bufferLength) {
					$valuationOutput .= '</optgroup>';
					$tagEnded = false;
				}
			}

			$valuationOutput .= '</select></div></td>'.
								'<td><span class="unitprice">0</span></td>'.	
								'<td><noscript class="quantity"><input type="text" name="quantity[]" value="0"></noscript></td>'.
								'<td><span class="item-amount">0</span></td></tr>';
					
			
		}
		
		$valuationOutput .= '</table><div class="submit"><p><a href="'.INDEX.'" class="button white">重來</a><button type="submit" id="submit" class="button green">送出</button></p><div class="amount"><small>總計金額（新台幣未稅）</small><div id="amount-price">0</div></div><div class="clearfix"></div></div><input type="hidden" name="mode" value="evaluate"><input type="hidden" name="validator" value="'.sha1($mTime).'"></form><script src="js/index.js"></script><!--[if lt IE 10]><script src="js/fuckyouie.js"></script><![endif]--></body></html>';