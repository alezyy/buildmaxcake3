<ul class="nav nav-tabs">
	<li class="active"><a href="#delivery" data-toggle="tab"><?php echo __("Delivery"); ?></a></li>
	<li><a href="#pickup" data-toggle="tab"><?php echo __("Pickup"); ?></a></li>
	<li><a href="#byname" data-toggle="tab"><?php echo __("By Name"); ?></a></li>
</ul>



<div class="tab-content" style="margin-top:50px; margin-left:10px; margin-right:10px;">
	<div class="tab-pane fade in active" id="delivery">
		<?php
		echo $this->Form->create(
		    'Location',
		    array(
		        'class' => 'form-inline',
		        'url' => array(
		        	'controller' => 'locations',
		        	'action' => 'search',
		        	'#' => 'search_delivery'
		        ),
		        'id' => 'delivery'
		    )
		);
		echo $this->Form->input(
			'type',
			array(
				'type'  => 'hidden',
				'value' => 'delivery'
			)
		);
		echo $this->Form->input(
			'postal_code1',
			array(
				'label' => __('Enter your Postal Code'),
				'class' => 'shadow_txtBox span1 postal_code1 pull-right',
				'maxlength' => 3,
				'style' => 'text-transform: uppercase;',
				'autocomplete' => 'off',
				'placeholder' => 'H0H',
				'tabindex' => 1
			)
		);
		echo $this->Form->end(
			array(
				'class' => 'btn btn-danger pull-right',
				'label' => __('Find a restaurant'),
				'tabindex' => 2
			)
		);
		?>

	</div>
	<div class="tab-pane fade" id="pickup">
		<?php
		echo $this->Form->create(
		    'Location',
		    array(
		        'class' => 'form-inline',
		        'url' => array(
		        	'controller' => 'locations',
		        	'action' => 'search',
		        	'#' => 'search_pickup'
		        ),
		        'id' => 'pickup'));
		echo $this->Form->input(
			'type',
			array(
				'type'  => 'hidden',
				'value' => 'pickup'));
		echo $this->Form->input(
			'postal_code1',
			array(
				'label' => __('Enter your Postal Code'),
				'class' => 'shadow_txtBox span1 postal_code1 pull-right',
				'maxlength' => 3,
				'style' => 'text-transform: uppercase;',
				'autocomplete' => 'off',
				'placeholder' => 'H0H',
				'tabindex' => 1));
		echo $this->Form->end(
			array(
				'class' => 'btn btn-danger pull-right',
				'label' => __('Find a restaurant'),
				'tabindex' => 2));
		?>

	</div>
	<div class="tab-pane fade" id="byname">

		<?php
		echo $this->Form->create(
		    'Location',
		    array(
		        'class' => 'form-inline',
		        'url' => array(
		        	'controller' => 'locations',
		        	'action' => 'search',
		        	'#' => 'search_byname'
		        ),
		        'id' => 'byname'
		    )
		);
		echo $this->Form->input(
			'name',
			array(
				'placeholder' => __('Restaurant Name'),
				'class' => 'shadow_txtBox span4',
				
				'label' => '',
				'tabindex' => 1
			)
		);
		echo $this->Form->end(
			array(
				'class' => 'btn btn-danger pull-right',
				'style' => 'margin-top:10px;',
				'label' => __('Find Restaurant'),
				'tabindex' => 2
			)
		);
		?>


	</div>

</div>
<?php
echo $this->Html->script('search_box', array('inline' => false));
