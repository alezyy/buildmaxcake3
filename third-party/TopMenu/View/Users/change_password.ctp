<?php
echo $this->Html->addCrumb(__('Change Password'));
?>
<div class="row">
	<div style="margin-left:60px;width:620px;">

		<?php echo $this->Session->flash('auth'); ?>
		<?php echo $this->Form->create('User');?>

				<h2><?php echo __('Change your Password'); ?></h2>
			<?php
				echo $this->Form->input('User.password_old', array(
					
					'label' => __('Current Password'),
					'type' => 'password'
				));
				echo $this->Form->input('User.password', array(
					'autocomplete' => 'off',
					'label' => __('New Password')
				));
				echo $this->Form->input('User.password_confirm', array(
					'autocomplete' => 'off',
					'type' => 'password',
					'label' => __('Confirm Password')
				));
			?>

		<?php echo $this->Form->end(array(
						'style' => 'float:right;',
						'label' => __('Change Password'),
						'class' => 'btn btn-success'
					));
		?>
	</div>
</div>

<?php
echo $this->element('password_meter');
$this->Html->script('password_meter', array('inline' => false));