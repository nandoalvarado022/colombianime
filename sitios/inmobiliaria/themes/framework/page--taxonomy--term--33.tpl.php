	<div class="slider-block">
	  <?php 
	  
		if ($exposed): ?><div class="view-filters"><?php print $exposed; ?></div><?php endif;  
		$view = views_get_view('buscador'); print $view->preview('block');

		?>
	</div>  
</div><!--back-container-->

<script>
	
</script>