<?php


echo $this->Form->input(
	'cuisine',
	array(
		'options' => $cuisines,
		'empty' => __('Cuisine Type'),
		'class' => 'span2 caption caption-no-image',
		'style' => 'position: inherit; webkit-border-radius: 0; -moz-border-radius: 0; border-radius: 0;',
		'div' => false,
		'no_div' => true,
		'label' => false,
		'id' => 'cuisineTypesSelect'));

echo $this->Form->create(
	'Location', array(
	'url' => array(
			'controller' => 'locations',
			'action' => 'search',
			'#' => 'search_' . $search_type),
	'style' => 'margin-bottom: 10px'));

if (empty($this->request->data['Location'])) {
	$locationQueryData = $this->Session->read('Search.Location');
} else {
	$locationQueryData = $this->request->data['Location'];
}
foreach ($locationQueryData as $key => $value) {
	if ($key != 'cuisine') {
		echo $this->Form->input(
			$key, array(
			'value' => $value,
			'type' => 'hidden',
			'div' => false,
			'no_div' => true));
	}
}

foreach ($cuisines as $key => $value) {
	echo $this->Form->input(
		'cuisines',
		array(
			'name' => 'cuisines[]',
			'value' => $key . ':' . $value,
			'type' => 'hidden',
			'div' => false,
			'no_div' => true
		)
	);
}
echo $this->Form->end();
?>


<div class="accordion" id="search_collapse">
  <div class="accordion-group">
	  <a class="accordion-toggle" data-toggle="collapse" data-parent="#search_collapse" href="#delivery">
		  <div class="accordion-heading category-no-image" data-toggle="collapse" >
			  <div class="caption caption-no-image">
				  <p>
					  <?php echo __("Delivery"); ?>
					  <span style="text-align: right">
					  <?php echo $this->Html->image('icon_collapsible.png', array('class' => 'icon_collapsible')); ?>						
					  </span>
				  </p>
			  </div>	  
		  </div>
	  </a>
	<div id="delivery" class="accordion-body collapse">
	  <div class="accordion-inner">
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
				'class' => 'shadow_txtBox span1 postal_code1 postal_code pull-right',
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
				'tabindex' => 2,
				'style' => 'margin-top: 20px;'
			)
		);
		?>
		<br/>
	  </div>
	</div>
  </div>
  <div class="accordion-group">
	  <a class="accordion-toggle" data-toggle="collapse"  data-parent="#search_collapse" data-parent="#search_collapse" href="#pickup">
		  <div class="accordion-heading category-no-image" data-toggle="collapse" >
			  <div class="caption caption-no-image">
				  <p>
					  <?php echo __("Pickup"); ?>
					  <?php echo $this->Html->image('icon_collapsible.png', array('class' => 'icon_collapsible')); ?>						
				  </p>
			  </div>	  
		  </div>
	  </a>

	<div id="pickup" class="accordion-body collapse">
	  <div class="accordion-inner">
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
		        'id' => 'pickup'
		    )
		);
		echo $this->Form->input(
			'type',
			array(
				'type'  => 'hidden',
				'value' => 'pickup'
			)
		);
		echo $this->Form->input(
			'postal_code1',
			array(
				'label' => __('Enter your Postal Code'),
				'class' => 'shadow_txtBox span1 postal_code1 postal_code pull-right',
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
				'tabindex' => 2,
				'style' => 'margin-top: 20px;'
			)
		);
		?>
		<br/>
	  </div>
	</div>
  </div>
</div>
<?php
echo $this->Html->script('search_selector', array('inline' => false));
echo $this->Html->script('search_box', array('inline' => false));

