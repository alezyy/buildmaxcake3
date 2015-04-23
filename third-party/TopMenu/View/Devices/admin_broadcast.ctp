<?php
$this->Html->addCrumb(
	__('Device Overview'),
	array(
		'controller' => 'devices',
		'action' => 'index',
		'admin' => true
	)
);
$this->Html->addCrumb(__('Send a Broadcast Message'));
?>
<div class="row">
	<div class="span12">
		<?
		echo $this->Form->create('Device');
		echo $this->Form->input(
			'message',
			array(
				'type' => 'textarea',
				'cols' => 30,
				'rows' => 20,
				'style' => 'resize:none;'
			)
		);
		echo $this->Form->end(array(
			'label' => __('Send Broadcast'),
			'class' => 'btn btn-success pull-right'
		));
		?>
	</div>
</div>