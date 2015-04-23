<div class="alert alert-error">
	<h1>
		<?php
		echo __('Your account isn\'t activated');
		?>
		<p>
			<small>
				<?php
				echo __('We have sent you an email with a link to activate your account. Please check your spam folder.');
				?>
			</small>
		</p>
	</h1>
	<p>
		<?php
		echo __('If you haven\'t received the email, click ');
		echo $this->Html->link(
			__('here'),
			array(
				'controller' => 'activate',
				'action' => 'resend',
				 $usrId
			 )
		 );
		 echo __(' to resend it.');
		 ?>
	 </p>
</div>