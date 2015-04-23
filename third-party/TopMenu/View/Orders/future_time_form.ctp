<div id="optionModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="gray_head_box">
		<div class="gray_head_heading">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">✖ </button>			
			<?php echo __('Pick what time you want to receive/pick up your order'); ?>
		</div>
	</div>
  
	<div class="modal-body future_date">
		<h5><?php echo __('Please, pick a date within the next week: '); ?></h5>
		<p><?php echo __('Click anywhere on the textbox to open a calendar.<br/> You will be able to choose the time after you have selected the date.'); ?></p>	
		<div id="requestForStatus"></div>
		
		<?php echo $this->Form->create('Order', array(
			'default' => FALSE,
			'id' => 'resquestForForm')); ?>
		
		<div class="input-append date form_datetime">
		<?php
		echo $this->Form->input('requested_for', array(
			'readonly' => 'readonly',
			'type' => 'text',
			'div' => FALSE,
			'no_div' => TRUE,
			'label' => FALSE,
			'size' => '16'));
		?>
			 <span class="add-on"><i class="icon-calendar"></i></span>
		<?php
		echo $this->Form->button(__('OK'), array(
			'class' => 'btn btn-success',
			'label' => FALSE,
			'type' => 'submit',
			'value' => 'OK'));
		?>
		</div>
		<p>
		<?php
		echo $this->Form->button(__('Cancel'), array(
			'class' => 'btn btn-danger pull-right',
			'id' => 'cancelBtn close',
			'data-dismiss' => 'modal',
			'aria-hidden' => 'true',
			'type' => 'button'));
		?>
		
		
		</p>


	</div>
		
		<br/>
		<?php echo $this->Form->hidden('mirrorField', array('id' => 'mirrorField')); ?>
		<?php echo $this->Form->end(); ?>

	
	<?php 
	
	echo $this->Html->css('bootstrap-datetimepicker.min');		// datetime picker lib
	echo $this->Html->script('datepicker' . DS . 'bootstrap-datetimepicker.min');	// datetime picker lib
	echo $this->Html->script('datepicker' . DS . 'locales' . DS . 'bootstrap-datetimepicker.'.$langSuffix);	// datetime picker lib
	
	echo $this->Html->scriptBlock($script);						// configure datetime picker
	
	// ajax submission
	$data = $this->Js->get('#resquestForForm')->serializeForm(array('isForm' => true, 'inline' => true));
	$this->Js->get('#resquestForForm')->event(
	   'submit',
	   $this->Js->request(
		array('action' => 'future_time_form', 'controller' => 'orders'),
		array(
			'update' => '#requestForStatus',
			'data' => $data,
			'async' => true,    
			'dataExpression'=>true,
			'method' => 'POST'
		)
	  )
	);
	echo $this->Js->writeBuffer(); 
