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

        $mainProductCache = array();
        $file_list = glob(NYAN_DIR_PRICES . '*.[tT][xX][tT]'); // read file list from system
        for ($i = 0; $i < count($file_list); $i ++) { // loop through files
            $fileBuffer = file($file_list[$i], FILE_IGNORE_NEW_LINES); // read file
            list($products, $amountOfProduct, $productCache) = $this->parse_priceFile($fileBuffer); // parse and split
            
            $category_name = $this->get_categoryName($file_list[$i]);
            $template->get_category($category_name, $amountOfProduct, $products);
            $mainProductCache = array_merge($mainProductCache, $productCache);
        }
        $cacheObj->save_cache('productCache', serialize($mainProductCache));

        $template->get_lowerIndex($cacheObj->mTime);
        $template->get_footer();
    }

    public function generate_checkout($productCache)
    {
        require NYAN_DIR_CORE . 'nyan_template.php'; // load template engine
        $template = new Nyan_Template($this->mode);

        list($valuation, $total) = $this->generate_valuation($productCache);

        ob_start();
        $template->get_valuation($valuation, $total);
        $content = ob_get_contents();
        ob_end_clean();


        $serial = $this->getRefString();
        $this->save_valuation($serial, $content);

        return $serial;
    }

    public function generate_show($serial)
    {
        require NYAN_DIR_CORE . 'nyan_template.php'; // load template engine
        $template = new Nyan_Template($this->mode);

        $template->get_header();

        $content = $this->fetch_valuation($serial);
        $template->show_valuation($content);

        $template->get_footer();
    }

    private function parse_priceFile($fileBuffer)
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
                    'name' => htmlspecialchars(trim($matches[1])),
                    'price' =>  trim(intval($matches[2]))
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

    private function get_categoryName($source)
    {
        // get rid of .txt
        preg_match("/(.*)\/(.*).([tT][xX][tT])/", $source, $matches);
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

    private function getRefString() {
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $string = strtoupper( base_convert(time(), 10, 36) );
        
        if( strlen($string) == 6 )
            $string = '0' . $string;
        
        $string .= $characters[mt_rand(0, strlen($characters)-1)];

        if (file_exists(NYAN_DIR_VALUATIONS . $string)) {
            return $this->getRefString();
        }

        return $string;
    }

    private function generate_valuation($productCache)
    {
        $total = 0;
        $itemNumber = 0;
        
        for($i = 0; $i < count($_POST['product']); $i++){

            //設定數量
            $quantity = $_POST['quantity'][$i];
            if ($quantity > 1000 || $quantity < 1) {
                $quantity = 0;
            }

            if ($quantity == 0) {
                continue;
            }

            if (!isset($productCache[$_POST['product'][$i]])) {
                continue;
            }

            //讀取報價
            $selectedProduct = $productCache[$_POST['product'][$i]];
            $productName = $selectedProduct['name'];
            $productPrice = $selectedProduct['price'];
            $subtotal = $productPrice * $quantity;

            //紀錄報價
            if (!isset($valuation[$productName])) {
                $valuation[$productName]['price'] = $productPrice;
                $valuation[$productName]['quantity'] = $quantity;
                $valuation[$productName]['subtotal'] = $subtotal;
            } else if ($valuation[$productName]['quantity'] + $quantity <= 1000) {
                $valuation[$productName]['quantity'] += $quantity;
                $valuation[$productName]['subtotal'] = $valuation[$productName]['price'] * $valuation[$productName]['quantity'];
            }

            $itemNumber++;
            $total += $subtotal;
        }

        if ($itemNumber == 0) {
            throw new Exception('您忘記選取報價項目！');
        }

        return array($valuation, $total);
    }

    private function fetch_valuation($serial)
    {
        $content = file_get_contents(NYAN_DIR_VALUATIONS . $serial);

        if ($content === false) {
            throw new Exception('報價單過期或不存在！');
        }

        return $content;
    }

    private function save_valuation($name, $content)
    {
        if (file_put_contents(NYAN_DIR_VALUATIONS . $name, $content) === false) {
            throw new Exception("無法寫入報價檔！");
        }
    }
}