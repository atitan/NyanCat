(function($){
	var quantityTemp = '<div class="selectbox disabled"><select class="item-quantity" name="quantity[]">',
		items = $('.list').find('.item'),
		amount = $('#amount-price'),
		prices = [];

	for (var i=0; i<10; i++){
		quantityTemp += '<option value="'+i+'">'+i+'</option>';
	}

	quantityTemp += '</select></div>';

	$('body').on('change', 'select', function(){
		$(this).prev().html($(this).find(':selected').html());
	});

	var calcAmount = function(){
		var price = 0;
		for (var i=0, len=prices.length; i<len; i++){
			price += prices[i][0] * prices[i][1];
		}
		amount.html(price);
	};

	var changeQuantity = function(obj, i, quantity){
		var $quantity = obj.find('.item-quantity');
		if (quantity == 0){
			$quantity.parent().addClass('disabled');
		} else {
			$quantity.parent().removeClass('disabled');
		}
		$quantity.children().eq(quantity).attr('selected', 'selected').end().trigger('change');
	};

	var init = function(i){
		var $this = $(this),
			clone = $this.clone();

		prices.push([0, 0]);

		$this.addClass('js').on('change', '.product', function(){
			var price = parseInt($(this).find(':selected').attr('data-price')) || 0;
			prices[i][0] = price;

			if (price == 0){
				changeQuantity($this, i, 0);
			} else if (prices[i][1] == 0) {
				changeQuantity($this, i, 1);
			}

			$this.find('.unitprice').html(price);
			$this.find('.item-amount').html(prices[i][0] * prices[i][1]);
			calcAmount();
		}).on('change', '.item-quantity', function(){
			var quantity = parseInt($(this).val()) || 0;
			prices[i][1] = quantity;
			$this.find('.item-amount').html(prices[i][0] * prices[i][1]);
			calcAmount();
		}).on('click', '.add-item', function(){
			var target = $this.next('.new').last().length ? $this.next('.new').last() : $this,
				element = clone.clone().addClass('new');

			init.call(element[0], prices.length);
			target.after(element);
		}).on('click', '.remove-item', function(){
			prices[i] = [0, 0];
			$this.remove();
			calcAmount();
		}).find('.quantity').each(function(){
			$(this).after(quantityTemp).remove();
		}).end().find('.selectbox').each(function(){
			$(this).prepend('<span>'+$(this).find(':selected').html()+'</span>').parent().addClass('js');
		});
	};

	items.each(function(i){
		init.call(this, i);
	});
})(jQuery);