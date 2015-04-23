<?php
echo $this->Html->addCrumb(__('Reset Your Password'));
?>
<div class="container">
	<div class="content" style="width:620px;">
		<?php
		echo $this->Session->flash('auth');
		echo $this->Session->flash();
		?>
		<div class="row">
			<legend style="margin-left:20px;"><?php echo __('Create a new Password'); ?></legend>

			<div class="login-form" style="width:620px;margin-left:-60px;">

				<?php echo $this->Form->create('User');?>
				    <fieldset>
				     <?php
				        echo $this->Form->input('User.password', array(
				        	'autocomplete' => 'off',
				        	'label' => 'New Password'
				        ));
				        echo $this->Form->input('User.password_confirm', array(
				        	'autocomplete' => 'off',
				        	'type' => 'password',
				        	'label' => 'Confirm Password'
				        ));
				    ?>
				    </fieldset>
				<?php
				echo $this->Form->end(array(
					'style' => 'float:right;',
					'label' => __('Change Password'),
					'class' => 'btn btn-primary'
				));
				?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
echo $this->element('password_meter');
$this->Html->script('password_meter', array('inline' => false));