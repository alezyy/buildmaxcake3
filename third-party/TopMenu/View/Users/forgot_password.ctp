
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Session->flash(); ?>
<div class="row" style="margin-top:50px;margin-bottom:20px;">

	<div class="span8 offset2">
		<h2 class="login-heading"><?php echo __('Password Reset'); ?></h2>
		<?php echo $this->Form->create('User');?>
	    <fieldset style="margin-left:-100px;">
	    <?php
	        echo $this->Form->input('User.forgot_email', array(
	        	
	        	'label' => __('Email Address'),
	        ));
	    ?>
	    </fieldset>
		<?php
		echo $this->Form->end(array(
			'style' => 'float:right;',
			'label' => __('Reset Password!'),
			'class' => 'btn btn-success',
			'data-toggle' => 'modal',
			'data-target' => '#' . $modal_id
		));
		?>
	</div>
</div>

<?php
echo $this->element('processing', array(
				'id' => $modal_id,
				'header' => __('One Moment Please…')
			));
$code = '$(\'#' . $modal_id . '\').bind(\'shown\', function () {
$(\'form\').submit();
});
$("#' . $modal_id  . '").modal({
	backdrop: \'static\',
	keyboard: false,
	show: false

});';
$this->Html->scriptBlock($code, array('inline' => false));
$this->Html->script('provinces', array('inline' => false));