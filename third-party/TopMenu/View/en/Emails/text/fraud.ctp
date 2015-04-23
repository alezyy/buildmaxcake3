
<b>Messages</b>
<table>	
<?php foreach ($Message as $value):?>
	<tr>
		<td><?php echo $value; ?></td>
	</tr>
<?php endforeach; ?>
</table>

<b>Restaurant</b>
<table>	
<?php foreach ($Location['Location'] as $key => $value):?>
	<tr>
		<td><?php echo $key; ?></td>
		<td><?php echo $value; ?></td>
	</tr>
<?php endforeach; ?>
</table>

<b>Utilisateur</b>
<table>	
<?php foreach ($User['User'] as $key => $value):?>
	<tr>
		<td><?php echo $key; ?></td>
		<td><?php echo $value; ?></td>
	</tr>
<?php endforeach; ?>
</table>

<b>Historique Commandes</b>
<table>	
	<tr>
		<th>Order ID</th>
		<th>Total</th>
		<th>Prenom</th>
		<th>Nom</th>
		<th>Addres</th>
		<th>Tel</th>
		<th>Paiement</th>
		<th>Accepté</th>
		<th>Transaction</th>
	</tr>
<?php foreach ($OrderHistory as $o):?>
	<tr>
		<td><?php echo $o['Order']['id'] ; ?></td>
		<td><?php echo $o['Order']['total'] ; ?></td>
		<td><?php echo $o['Order']['first_name'] ; ?></td>
		<td><?php echo $o['Order']['last_name'] ; ?></td>
		<td><?php echo $o['Order']['address'] ; ?>, <?php echo $o['Order']['address2'] ; ?>, <?php echo $o['Order']['city'] ; ?>, <?php echo $o['Order']['postal_code'] ; ?></td>
		<td><?php echo $o['Order']['phone'] ; ?></td>
		<td><?php echo $o['Order']['method_of_payment'] ; ?></td>
		<td><?php echo $o['Order']['transaction_number'] ; ?></td>	
	</tr>
	
	
<?php endforeach; ?>
</table>
