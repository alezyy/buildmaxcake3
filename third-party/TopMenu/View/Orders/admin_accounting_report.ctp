<?php
$this->Html->addCrumb(__('Orders'), array(
	'controller' => 'orders',
	'action'	 => 'index'
));
?>

<!-- Generate Report -->
<style>
	.form_table td{padding: 7px; font-size: 13pt;}
	.order .form {width: 650px; margin:auto;}
	.orders table {width: 600px}
</style>
<div class="location">
	
	<!-- By restaurants reports -->
	<div class="orders form span10">
		<?php echo $this->Form->create('Report'); ?>
		<fieldset>
			<legend><?php echo __('By Restaurant Report'); ?></legend>
			<table class="form_table" >
				<tr>
					<td><?php echo __('From (inclusive): '); ?></td>
					<td><?php
						echo $this->Form->dateTime(
							'start_date', 'YMD', null, array(
							'separator'	 => ' - ',
							'value'		 => time() - (16 * DAY),
							'style'		 => 'width: 80px'));
						?>
					</td>
				</tr>
				<tr>
					<td><?php echo __('To (inclusive): '); ?></td>
					<td><?php
						echo $this->Form->dateTime(
							'end_date', 'YMD', null, array(
							'separator'	 => ' - ',
							'value'		 => time() - DAY,
							'style'		 => 'width: 80px'));
						?>
					</td>
				</tr>
                <tr>
                    <td title="<?php echo __('Check to show, on the restaurant page, there order history for the period'); ?>">
                        <?php echo __('Show Details?: '); ?></td>
					<td><?php echo $this->Form->checkbox('show_details'); ?></td>
				</tr> 
                <tr>
                    <td title="<?php echo __('Choose a specific restaurant or leave empty for to generate report for all restaurants'); ?>"><?php echo __('Restaurant: '); ?></td>
                    <td>
                        <?php echo $this->Form->select('location', $locations); ?>
                    </td>
				</tr>                 
				<tr>
					<td colspan="2" style="text-align: right">
						<?php echo $this->Form->submit(__('Generate Report'), array('name' => 'report', 'id' => 'generateCsvSubmit')); ?>
					</td>
				</tr>
			</table>			
		</fieldset>
		<?php echo $this->form->end(); ?>
	</div>
	
	<!-- By Orders Report -->
	<div class="orders form span10">
		<?php echo $this->Form->create('ReportByOrder'); ?>
		<fieldset>
			<legend><?php echo __('By Orders Report (Old reports)'); ?></legend>
			<table class="form_table" >
				<tr>
					<td><?php echo __('From (inclusive): '); ?></td>
					<td><?php
						echo $this->Form->dateTime(
							'start_date', 'YMD', null, array(
							'separator'	 => ' - ',
							'value'		 => time() - (16 * DAY),
							'style'		 => 'width: 80px'));
						?>
					</td>
				</tr>
				<tr>
					<td><?php echo __('To (inclusive): '); ?></td>
					<td><?php
						echo $this->Form->dateTime(
							'end_date', 'YMD', null, array(
							'separator'	 => ' - ',
							'value'		 => time() - DAY,
							'style'		 => 'width: 80px'));
						?>
					</td>
				</tr>                               
				<tr>
					<td><?php echo __('With coupons only?: '); ?></td>
					<td><?php echo $this->Form->checkbox('coupons_only'); ?></td>
				</tr>                
				<tr>
					<td><?php echo __('Excel language?: '); ?></td>
					<td>
						<?php
						echo $this->Form->select('delimeter', array(
							';'	 => __('French Excel (semi-colon)'),
							','	 => __('Other (comma)')),
							array('value' => ';', 'empty' => false));
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php echo __('Get specific orders only <b>(seperate order numbers with commas)</b>'); ?>
					</td>
				</tr>                
				<tr>				
					<td colspan="2">
						<?php
						echo $this->Form->input('order_ids', array(
							'style'	 => 'width: 100%;',
							'label'	 => FALSE,
							'div'	 => FALSE));
						?>
					</td>
				</tr>
                
				<tr>
					<td colspan="2" style="text-align: right">
						<?php echo $this->Form->submit(__('Generate Report'), array('name' => 'ReportByOrder', 'id' => 'generateCsvSubmit')); ?>
					</td>
				</tr>
			</table>			
		</fieldset>
		<?php echo $this->form->end(); ?>
	</div>

	<!-- Remove orders from report -->
	<div class="orders form span10">
		<?php echo $this->Form->create('Order'); ?>
		<fieldset>
			<legend><?php echo __('Remove orders from report') ?></legend>
			<table class="form_table" >
				<tr>
					<td>
						<?php echo __("Order number: ") ?>&nbsp;
						<?php echo __('<b>(seperate order numbers with commas)</b>'); ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						echo $this->Form->input('identity', array(
							'style'	 => 'width: 100%;',
							'label'	 => FALSE,
							'div'	 => FALSE));
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right">
						<?php echo $this->Form->submit(__('DELETE'), array('name' => 'delete')); ?>
					</td>
				</tr>
			</table>			
		</fieldset>
		<?php echo $this->form->end(); ?>



	<!-- Add username that for which orders are not accounted (set to deleted)--></div>
	<div class="orders form span10">
		<?php echo $this->Form->create('User'); ?>
		<fieldset>
			<legend><?php echo __('Testing user accounts') ?></legend>
			<table class="form_table" >
				<tr>
					<td>
						<?php echo __('Add users to the list of user that should not appear on the report: ') ?><br/>
						<?php echo __('<b>(seperate order numbers with commas)</b>'); ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						echo $this->Form->input('email', array(
							'style'	 => 'width: 100%;',
							'div'	 => false,
							'label'	 => false
						));
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right">
						<?php echo $this->Form->submit(__('ADD'), array('name' => 'add_user')); ?>
					</td>
				</tr>
			</table>
			<?php echo $this->form->end(); ?>
		</fieldset>
	</div>

</div>

    <?php echo $this->Html->script('Chart.js'); ?>
<div class="orders form span10" id="prettyChart">
    <fieldset>
        <legend><?php echo __('Orders Total by months in last years ($)') ?></legend>
        <canvas id="lineChart" width="1000" height="600"></canvas>
		<p id="chartLegend" class="strong"></p>
    </fieldset>
</div>

<script>
	$('#generateCsvSubmit').click(function(){
		$('#please_wait_spinner').remove();
	});
	
	var lineData = <?php echo $lineData ?>;                                     // data from php
	
	// Legend
	var legend = '<ul>';
	for (var key in lineData.datasets) {
		legend = legend + "<li><div style=\"float: left; width: 95%; background-color:" + lineData.datasets[key]. fillColor + "\">&nbsp;</div><div style=\"float: right; width: 5%; text-align: right\">" + lineData.datasets[key].label + "</div></li>";
	  
	}	
	legend = legend + '</ul>';
    
    // Line Chart
    var options = {
			bezierCurve : false,
			responsive: true,
			legendTemplate: legend
		};
    
    var ctx2 = document.getElementById("lineChart").getContext("2d");           // Get the context of the canvas element we want to select        
    var myLineeChart = new Chart(ctx2).Line(lineData, options);                          // instantiated the Pie Chart class on the canvas
	var legendMarkup = myLineeChart.generateLegend();			
	$("#chartLegend").html(legendMarkup);
	console.log(legendMarkup);
	

	
</script>