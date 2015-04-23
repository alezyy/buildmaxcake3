<?php
$this->Html->addCrumb(__('Location Redirects'), array(
	'controller' => 'location_redirects',
	'action' => 'index'
));
$this->Html->addCrumb(__('Add Location Redirect'));
?>
<div class="locationRedirects form">
<?php echo $this->Form->create('LocationRedirect'); ?>
	<fieldset>
		<legend><?php echo __('Add Location Redirect'); ?></legend>
	<?php
		echo $this->Form->input('location_id');
		echo $this->Form->input('old_url');
	?>
	</fieldset>
<?php
echo $this->Form->end(
	array(
		'label' =>  __('Submit'),
		'class' => 'btn btn-success offset6'
	)
);
?>
</div>