<p>Hello <?php echo h($name); ?> !</p>
<br/>
<p>
	You're almost done!. We just need to validate your email address, <a href="<?php echo $activate_url; ?>">Click here </a> to validate it now!
</p>

<?php
echo $this->element('email_footer_en');