<div class="mask">
	<form id="maskselection">
		<?php for ($i = 0; $i <= 21; $i++) {?>
			<label>
				<input type="radio" name="filter" value="1" checked>
				<img src="/public/masks/<?php echo $i;?>.png" width="50%">
			</label>
		<?php } ?>
	</form>
</div>
