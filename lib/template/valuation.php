<p>報價單產生時間：<?php echo date("Y-m-d H:i:s"); ?></p></header>
    <div class="alignleft">
    <table class="list">
        <tr>
            <th>商品項目</th>
            <th>單價</th>
            <th>數量</th>
            <th>小計</th>
        </tr>
        <?php echo $valuation_output; ?>
        <tr>
            <td colspan="3">總計金額（新台幣未稅）</td>
            <td><?php echo $total; ?></td>
        </tr>
    </table>