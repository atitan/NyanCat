<div id="container">
	<header id="header"><h1><?php echo SITENAME; ?></h1>
		<?php echo $content; ?>
		<div id="checksum-link">
			<label for="checksum">估價單連結</label>
			<input type="text" readonly="readonly" id="checksum" value="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"><br>
			<button type="button" id="print" class="button white">列印</button>
			<a href="http://www.nyan.cat/" target="_blank" id="nyan" class="button white">什麼是 Nyan Cat？</a>
		</div>
	</div>
	<div class="clearfix"></div>
</div>