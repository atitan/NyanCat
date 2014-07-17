<body>
    <header id="header">
        <h1><?php echo SITENAME; ?></h1>
        <p>
            項目未列出≠我們就沒有，打※號產品為非常備庫存<br>
            歡迎來電洽詢或於估價單中備註您的需求，謝謝！<br><br>
            <strong>報價最後更新：<?php echo date("Y-m-d H:i:s", $mTime); ?></strong>
        </p>
    </header>
    <form action="checkout.php" method="post" accept-charset="utf-8" target="_blank">
        <noscript class="nojs">
            您的瀏覽器不支援 Javascript。<br>
            沒關係！只要選取品項和輸入數量，您一樣可以估價！報價將在送出後顯示！
        </noscript>
        <table class="list">
            <tr>
                <th></th>
                <th>商品項目</th>
                <th>單價</th>
                <th>數量</th>
                <th>小計</th>
            </tr>