<div>
	<div id="content_inner">
		<div class="right_cntnr_630" >
		    <div class="gray_head_box">
		        <h1 class="gray_head_heading">
		        	<?php echo __('Sign Up'); ?>
		        </h1>
		    </div>
		    <div class="featured_restaurants">
		        <div  style="margin-right:60px;">
		        		<div class="row">
			        		<div class="span6 offset2">
					        	<?php echo $this->Session->flash('auth'); ?>
								<?php echo $this->Session->flash(); ?>
							</div>
						</div>
						<?php echo $this->Form->create('User');?>
						<fieldset>
							<?php

							echo $this->Form->input('Profile.first_name');
							echo $this->Form->input('Profile.last_name');
							echo $this->Form->input('User.email', array('autocomplete' => 'off'));
							echo $this->Form->input('User.password', array('autocomplete' => 'off'));
							echo $this->Form->input('User.password_confirm', array(
								'label' => __('Confirm Password'),
								'type' => 'password',
								'autocomplete' => 'off'
							));

							echo $this->Form->input('Profile.phone');
							echo $this->Form->hidden(
								'Profile.timezone',
								array('value' => 'America/Montreal'));?>
				
						<?php
						echo $this->Form->end(array(
							'style' => 'float:right;',
							'label' => __('Sign Up!'),
							'class' => 'btn btn-success',
							'data-toggle' => 'modal',
							'data-target' => '#' . $modal_id
						));
						?>
									</fieldset>
					</div>

		    </div>
		</div>
		<!-- Left Container Ends -->

		<!-- Right Container Starts -->
		<div class="pages_left_280" >
		    <div class="small_header_cntnr">
		        <div style="font-size: 14px;" class="small_header_title"><strong><?php echo __('Contest Rules'); ?></strong></div>
		    </div>
		    <div class="other_pages_left_tab">
		        <table width="100%" cellspacing="0" cellpadding="0" border="0">
		            <tbody><tr>
		                <td>
		                    <ul>
		                        <li class="li_small"><a target="_blank" href="/pages/view/contest"><?php echo __('Click here to win!'); ?></a></li>
		                    </ul>
		                </td>
		            </tr>
		        </tbody></table>
		    </div>		    
		    <div class="left_box-shadow">&nbsp;</div>
		</div>
		
		
		<div class="pages_left_280" >
		<div class="small_header_cntnr">
		        <div class="small_header_title"><strong><?php echo __('Why should I sign up?'); ?></strong></div>
		    </div>

		    <div class="other_pages_left_tab">
		        <table width="100%" cellspacing="0" cellpadding="0" border="0">
		            <tbody>
		            	<tr>
			                <td>
			                    <ul>
			                        <li class="li_small"><?php echo __('Earn points for freebies!'); ?></li>
			                        <li class="li_small"><?php echo __('Save time and order from your history'); ?></li>
			                        <li class="li_small"><?php echo __('Save your delivery address!'); ?></li>
			                    </ul>
			                </td>
			            </tr>
			        </tbody>
			    </table>
		    </div>
		</div>			
		<!-- Right Container Ends -->
		<div class="clear"></div>
		<div class="clear"></div>
	</div>
</div>

<?php
echo $this->element('processing', array(
				'id' => $modal_id,
				'header' => __('Creating your Account!')
			));
$code = '$(\'#' . $modal_id . '\').bind(\'shown\', function () {
$(\'form\').submit();
});
$("#' . $modal_id  . '").modal({
	backdrop: \'static\',
	keyboard: false,
	show: false

});';
echo $this->element('password_meter');
echo $this->Html->script('password_meter', array('inline' => false));
echo $this->Html->scriptBlock($code, array('inline' => false));
echo $this->Html->script('provinces', array('inline' => false));
echo $this->Html->script('register');
