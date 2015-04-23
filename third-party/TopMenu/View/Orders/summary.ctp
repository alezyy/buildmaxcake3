<div class="search_wrapper">
	&nbsp;
	<div class="other_pages_left">
		<div id="search" data-spy="affix" data-offset-top="260" data-offset-bottom="250" style="margin-left: 44px">
	        <div class="small_header_cntnr">
	            <h1 class="small_header_title"><strong><?php echo __('Your Order'); ?></strong></h1>
	        </div>

	        <div class="other_pages_left_tab">
	            <table class="cart_table_content" id="order_content">
							<tbody>
								<?php //if ($orderIsEnable) {  ?>

								<tr>
									<td width="55%" class="arial10"><?php echo __('Items'); ?></td>
									<td width="15%" class="arial10"><?php echo __('QTY'); ?></td>
									<td width="20%" class="arial10"><?php echo __('Price'); ?></td>
									<td width="10%"></td>
								</tr>
								<tr>
									<td colspan="4" class="cart_dotted_line">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2"><?php echo __('Subtotal'); ?></td>
									<td>$0.00</td>
									<td></td>
								</tr>
								 TAXES 
								<tr>
									<td colspan="2"><?php echo __('Tip'); ?></td>
									<td id="tip_td">
										<?php echo $this->Number->currency($this->Session->read('Order.Order.tip', $this->request->language. '_' . Configure::read('I18N.COUNTRY_CODE_2')));?>
									</td>
									<td align="right">
										<a href="#" onclick="remove_tips(); return false;">
											<img src="http://staging.topmenu.com//resources/front/images/icon_remove_item.jpg" border="0">
										</a>
									</td>
								</tr>
								<tr>
									<td colspan="2"><strong><?php echo __('Total'); ?></strong></td>
									<td id="total_td" class="strong">
										<?php echo $this->Number->currency($this->Session->read('Order.Order.total', $this->request->language. '_' . Configure::read('I18N.COUNTRY_CODE_2')));?>
									</td>
									<td></td>
								</tr>
							<input type="hidden" name="val_total" id="val_total" value="0.00">
							<tr>
								<td colspan="4">&nbsp;</td>
							</tr>
							<?php //} else {  ?>
							
							<?php if (!$locationIsOnline) { ?>
								<tr>
									<td colspan="4">
										<div class="alert alert-error fade in">
											<?php echo __('This Restaurant is currently not accepting online orders'); ?>
										</div>
									</td>
								</tr>
							<?php } ?>
							<?php //}  ?>
							</tbody>
						</table>	
	        </div>
	        <div class="left_box-shadow">&nbsp;</div>
	    </div>
	</div>
</div>