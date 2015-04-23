<div class="other_center">
	<div class="gray_head_box">
		<div class="gray_head_heading">
			<h1><?php echo __('Edit Delivery Address'); ?></h1>
		</div>
	</div>
	<div class="location_view">

<div class="login_box_one offset3 span5">



		<fieldset>        
		<h2>
			<?php echo __('Edit your delivery address'); ?>
		</h2>
			<?php
			echo $this->Form->input('name');
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
				'selected' => Configure::read('I18N.COUNTRY_CODE_2')));

			echo $this->Form->input('postal_code');
			echo $this->Form->input('cross_street');
			echo $this->Form->hidden('id');
			?>
		</fieldset>
		<?php
		echo $this->Form->end(
			array(
				'class' => 'btn btn-danger pull-right',
				'label' => __('Save')
			)
		);
		?>

		<div class="clear">&nbsp;</div>
		<div class="actions right">
			<ul>

				<li>
					<?php
					echo $this->Form->postLink(
						__('Delete'), array(
						'action' => 'user_delete',
						$this->Form->value('DeliveryAddress.id')), null, __('Are you sure you want to delete this delivery address'));
					?>
				</li>
				<li>
					<?php
					echo $this->Html->link(__("Add delivery address"), array(
						'controller' => 'delivery_addresses',
						'action' => 'user_add'), array('class' => 'edit'));
					?>   
		</li><li>

			<?php
			echo $this->Html->link(__("My Account"), array(
				'controller' => 'user',
				'action' => 'my_account'), array('class' => 'edit'));
			?>   
				</li>
			</ul>
		</div>
