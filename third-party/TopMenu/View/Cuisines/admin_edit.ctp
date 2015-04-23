<?php
$this->Html->addCrumb(__('Cuisines'), array(
	'controller' => 'cuisines',
	'action' => 'index',
	'admin' => true
));
$this->Html->addCrumb(__('Edit Cuisine'));
?>
<div class="cuisines form span10">
    <?php echo $this->Html->script('ckeditor/ckeditor'); ?>

<?php echo $this->Form->create('Cuisine'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Cuisine'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name_en');
		echo $this->Form->input('name_fr');
    ?>
        
        <p><label><?php echo __('ENGLISH Description'); ?></label></p>
        <?php echo $this->Form->input('description_en', array('label' => false)); ?>
        <p><label><?php echo __('FRENCH Description'); ?></label></p>
        <?php echo $this->Form->input('description_fr', array('label' => false));?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<script>
    CKEDITOR.replace( 'CuisineDescriptionEn' );
    CKEDITOR.replace( 'CuisineDescriptionFr' );
</script>