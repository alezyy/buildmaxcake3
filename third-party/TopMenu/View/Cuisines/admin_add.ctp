<?php
$this->Html->addCrumb(__('Cuisines'), array(
	'controller' => 'cuisines',
	'action' => 'index',
	'admin' => true
));
$this->Html->addCrumb(__('Add Cuisine'));
?>
<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<script>
    CKEDITOR.replace( 'CuisineDescriptionEn' );
    CKEDITOR.replace( 'CuisineDescriptionFr' );
</script>
<div class="cuisines form span10">
<?php echo $this->Form->create('Cuisine'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Cuisine'); ?></legend>
	<?php
		echo $this->Form->input('name_en');
		echo $this->Form->input('name_fr');
        echo $this->Form->input('description_en');
		echo $this->Form->input('description_fr');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>