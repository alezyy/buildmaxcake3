
<div id="imageModal" class="modal hide fade">

	<div class="gray_head_box">
		<div class="gray_head_heading">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">✖</button>
			<?php echo $itemName ?>

		</div>
	</div>
	<div class="modal-body">
		<?php 
		echo $this->Image->out($imageId, 'original');
		?>
	</div>
</div>