

	<?php echo $this->Form->create('DeliveryAddress', array(
		'inputDefaults' => array(
			'div' => 'form-group',
			'label' => array(
				'class' => 'col-sm-3 control-label'
			),
			'before' => '<div class="col-sm-9">',
			'class' => 'form-control',
			'after' => '</div>',
			'format' => array('label', 'before', 'input', 'between', 'after', 'error')
		),
		'url' => array('controller' => 'delivery_addresses', 'action' => 'user_add'),
		'class' => 'form-horizontal',
		'id' => 'addNewAddressForm'
	)); ?>

	

		<?php echo $this->Form->input('name', array(
				'label' => array(
					'text' => __('Address Label'),
					'class' => 'col-sm-3 control-label'
				)
			)
		);
		echo $this->Form->input('address');
		echo $this->Form->input('address2');
		echo $this->Form->input('city');
		echo $this->Form->input('province');
		echo $this->Form->hidden('DeliveryAddress.country', array(
				'empty' => __('Select a Country'),
				'id' => 'country',
				'value' => Configure::read('I18N.COUNTRY_CODE_2')
			)
		);
		echo $this->Form->input('phone');
		echo $this->Form->input('postal_code');
		echo $this->Form->input('cross_street');

		echo $this->Form->submit(
			__('ADD'),
			array(
				'id' => 'add_addresse_form_submit_button',
				'class' => 'btn btn-primary pull-right'
			)
		);

	
		echo $this->Form->end();
	
		?>

	


