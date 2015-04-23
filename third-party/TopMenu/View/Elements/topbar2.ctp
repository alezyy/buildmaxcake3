<div id="header">
	<div id="header_wrapper">
		<div class="left"> 
			<div class="logo">
				<?php
				echo $this->Html->link(
					$this->Html->image('topmenu_logo.png'), array(
					'controller' => 'homes',
					'action' => 'index',
					'admin' => false
					), array(
					'escape' => false
					)
				);
				?>
				<span style="
					position: relative;
					top: -19px;
					left: 45px;
					font-weight: bold;
					font-size: 12pt;
					color: lightgrey;
					text-decoration: none !important;"><?php echo __(''); ?></span>
			</div>

		</div>
 
		<div class="right">
			<?php
			echo $this->element('top_bar_content');
			?>
		</div>
		<div class="clear"></div>        
	</div>
</div>
<?php
if ($admin) {
	echo $this->element('admin_menu');
}
?>
