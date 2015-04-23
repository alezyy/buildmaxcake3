<p>Hello <?php echo h($name); ?> !</p>
<br/>
<p>
	Thanks for your request regarding your password. <a href="<?php echo $forgot_url; ?>">Please click here </a> to reset it.
</p>
<p>If you did not request a reset, please ignore this email.</p>


<?php
echo $this->element('email_footer_en');