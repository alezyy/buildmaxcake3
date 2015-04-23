Hello <?php echo h($name); ?> !

You're almost done!. We just need to validate your email address,
Copy and paste the following link into your browser's address bar

<?php echo $activate_url; ?>

to validate it now!


<?php
echo $this->element('email_footer_text_fr');