<p>Bonjour <?php echo h($name); ?> !</p>
<br/>
<p>	
	Nous avons reçu votre demande de réinitialisation de mot de passe.<a href="<?php echo $forgot_url; ?>">Cliquez ici </a> pour le changer.
</p>
<p>Si vous n'avez pas envoyé cette demande, ignorez simplement ce courriel.</p>


<?php
echo $this->element('email_footer_fr');