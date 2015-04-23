<p>Salut <?php echo h($name); ?> !</p>
<br/>
<p>
	Presque fini :) Il nous reste juste à valider ton adresse email <a href="<?php echo $activate_url; ?>">Clique ici </a> pour le confirmer!
</p>

<?php
echo $this->element('email_footer_fr');