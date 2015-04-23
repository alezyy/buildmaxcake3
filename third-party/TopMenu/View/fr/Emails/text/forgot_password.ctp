Hello <?php echo h($name); ?> !

We've received a request to reset your password.

To reset it, copy this link into your browser's address bar:

<?php echo $forgot_url; ?>

If you did not request a reset, please ignore this email.



<?php
echo $this->element('email_footer_text_fr');