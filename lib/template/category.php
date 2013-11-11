<tr class="item">
	<td>
		<a class="add-item" href="javascript:void(0)" title="新增"></a>
		<a class="remove-item" href="javascript:void(0)" title="移除"></a>
	</td>
	<td>
	<div class="selectbox">
		<select class="product" name="product[]">
			<option><?php echo $category_name; ?>  --  共計<?php echo $amountOfProduct; ?>樣 (尚未選擇) </option>
			<?php echo $category_output; ?>
		</select>
	</div>
	</td>
	<td>
		<span class="unitprice">0</span>
	</td>
	<td>
		<noscript class="quantity">
			<input type="text" name="quantity[]" value="0">
		</noscript>
	</td>
	<td>
		<span class="item-amount">0</span>
	</td>
</tr>