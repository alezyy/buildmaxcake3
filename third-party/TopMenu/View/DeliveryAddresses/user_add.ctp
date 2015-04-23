<div class="deliveryAddresses form span8">
	<?php 
		if (!empty($successPage) && $successPage !== 'login'){
			echo $this->Html->link(__('Go back to the menu'), '/'.$language.'/restaurant/'.$successPage);
		}
	?>
	<div class="other_center">
	<div class="gray_head_box">
		<div class="gray_head_heading">
			<h1><?php echo __('Add a Delivery Address'); ?></h1>
		</div>
	</div>

	<div class="location_view">
	<fieldset>
		<?php
		echo $this->Form->create('DeliveryAddress', array(
			'url' => array(
				'controller' => 'delivery_addresses',
				'action' => 'user_add',
				$successPage)));
		?>


		<?php
		echo $this->Form->input('name', array('label' => __('Address Label')));
		echo $this->Form->input('phone');
		echo $this->Form->input('secondary_phone');
		echo $this->Form->input('address');
		echo $this->Form->input('address2');
		echo $this->Form->input('city');

		echo $this->Form->input(
			'DeliveryAddress.province', array(
			'empty' => __('Select a Province'),
			'type' => 'select',
			'id' => 'provinces',
			'class' => 'shadow_txtBox w_210',
			'selected' => 'Quebec'
			)
		);

		echo $this->Form->input(
			'DeliveryAddress.country', array(
			'empty' => __('Select a Country'),
			'type' => 'select',
			'id' => 'country',
			'class' => 'shadow_txtBox w_210',
			'selected' => Configure::read('I18N.COUNTRY_CODE_2')
			)
		);

		echo $this->Form->input('postal_code');
		echo $this->Form->input('cross_street');
		?>
		<?php 
		if (!empty($successPage)) {
			echo $this->Form->hidden('success_page', array('value' => $successPage));
		} 
		?>

		<?php		
		echo $this->Form->end(
			array(
				'class' => 'btn btn-danger pull-right',
				'label' => __('OK'),
//				'data-toggle' => 'modal',
//				'data-target' => '#' . $modal_id
				));
		?>

	</fieldset>
	


<!-- Edit Links-->
<?php
echo $this->Html->link(__("Edit Profile"), array(
	'controller' => 'profiles',
	'action' => 'edit'), array('class' => 'edit'));
?>
&nbsp;|&nbsp;

<?php
echo $this->Html->link(__("Verify Delivery Addresses"), array(
	'controller' => 'DeliveryAddresses'), array('class' => 'edit'));
?>   
&nbsp;|&nbsp;

<?php
echo $this->Html->link(__("My Account"), array(
	'controller' => 'user',
	'action' => 'my_account'), array('class' => 'edit'));
?>   
</div>
</div>
</div>

<?php
//echo $this->element('processing', array(
//				'id' => $modal_id,
//				'header' => __('Creating your address!')));
//
//$code = '$(\'#' . $modal_id . '\').bind(\'shown\', function () {
//$(\'form\').submit();
//});
//$("#' . $modal_id  . '").modal({
//	backdrop: \'static\',
//	keyboard: false,
//	show: false
//
//});';
//echo $this->Html->scriptBlock($code, array('inline' => false));
