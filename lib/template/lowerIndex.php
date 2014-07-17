</table>
<div class="submit">
    <p>
        <a href="index.php" class="button white">重來</a>
        <button type="submit" id="submit" class="button green">送出</button>
    </p>
    <div class="amount">
        <small>總計金額（新台幣未稅）</small>
        <div id="amount-price">0</div>
    </div>
    <div class="clearfix"></div>
</div>
<input type="hidden" name="cache-validator" value="<?php echo md5($mTime); ?>">
</form>