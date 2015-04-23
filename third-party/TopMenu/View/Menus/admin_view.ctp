<?php

$this->Html->addCrumb(__('Locations'), array(
	'controller' => 'locations',
	'action' => 'index'
));
$this->Html->addCrumb(__('View Location'), array(
	'controller' => 'locations',
	'action' => 'view',
	$location_id
));

$this->Html->addCrumb(__('Menus'), array(
	'controller' => 'menus',
	'action' => 'index',
	$location_id
));

$this->Html->addCrumb(__('View Menu'));
?>
<div class="row">
	<div class="menus view span8">
		<dl class="well">
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($menu['Menu']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($menu['Menu']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Location'); ?></dt>
			<dd>
				<?php echo $this->Html->link($menu['Location']['name'], array('controller' => 'locations', 'action' => 'index')); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Status'); ?></dt>
			<dd>
				<?php echo h($menu['Menu']['status']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="actions pull-right">
		<h3><?php echo __('Actions'); ?></h3>
		<ul class="nav nav-tabs nav-stacked">
			<li>
				<?php
				echo $this->Html->link(
					__('Edit Menu'),
					array(
						'action' => 'edit',
						$location_id,
						$menu['Menu']['id']
					)
				);
				?>
			</li>
			<li>
				<?php
				echo $this->Form->postLink(
					__('Delete Menu'),
					array(
						'action' => 'delete',
						$location_id,
						$menu['Menu']['id']
					),
					null,
					__('Are you sure you want to delete # %s?', $menu['Menu']['id'])
				);
				?>
			</li>
			<li>
				<?php
				echo $this->Html->link(
					__('List Menus'),
					array(
						'action' => 'index',
						$location_id
					)
				);
				?>
			</li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="span12">
		<h2><?php echo __('Menu'); ?></h2>
		<ul class="nav nav-tabs">
			<li>
				<?php
				echo $this->Html->link(
					__('Add Category'),
					array(
						'controller' => 'menu_categories',
						'action' => 'add',
						$location_id,
						$menu['Menu']['id']
					)
				);
				?>
			</li>
		</ul>
		<div class="accordion" id="accordion">
			<?php foreach ($menu_categories as $menu_category): ?>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $menu_category['MenuCategory']['id']; ?>">
					  		<?php echo $this->Image->out($menu_category['MenuCategory']['image']); ?>
					  		<?php echo $menu_category['MenuCategory']['name_fr']; ?> / <?php echo $menu_category['MenuCategory']['name_en']; ?>
						</a>
					</div>

					<div id="<?php echo $menu_category['MenuCategory']['id']; ?>" class="accordion-body collapse">
						<div class="accordion-inner">
							<ul class="nav nav-tabs">
								<li class="pull-right">
									<?php
									echo $this->Form->postLink(
										__('Delete Category'),
										array(
											'controller' => 'menu_categories',
											'action' => 'delete',
											$location_id,
											$menu_category['Menu']['id'],
											$menu_category['MenuCategory']['id']

										),
										null,
										__('Are you sure you want to delete %s?', $menu_category['MenuCategory']['name'])
									);
									?>
								</li>
								<li class="pull-right">
									<?php
									echo $this->Form->postLink(
										__('Duplicate Category'),
										array(
											'controller' => 'menu_categories',
											'action' => 'duplicate',
											$menu_category['MenuCategory']['id']
										),
										null
									);
									?>
								</li>
								<li class="pull-right">
									<?php
									echo $this->Html->link(
										__('Edit Category'),
										array(
											'controller' => 'menu_categories',
											'action' => 'edit',
											$location_id,
											$menu_category['Menu']['id'],
											$menu_category['MenuCategory']['id']

										)
									);
									?>
								</li>
								<li class="pull-right">
									<?php
									echo $this->Html->link(
										__('Add Item'),
										array(
											'controller' => 'menu_items',
											'action' => 'add',
											$location_id,
											$menu_category['Menu']['id'],
											$menu_category['MenuCategory']['id']

										)
									);
									?>
								</li>
								<li class="pull-right">
									<?php
									echo $this->Html->link(
										__('Edit Options/Extras'),
										array(
											'controller' => 'menu_item_options',
											'action' => 'index',
											$location_id,
											$menu_category['Menu']['id'],
											$menu_category['MenuCategory']['id']

										)
									);
									?>
								</li>
								<li>
									<?php
									echo $this->Html->link(
										'<i class="icon-arrow-up"></i>',
										array(
											'controller' => 'menu_categories',
											'action' => 'move_up',
											'admin' => true,
											$location_id,
											$menu['Menu']['id'],
											$menu_category['MenuCategory']['id']
										),
										array(
											'escape' => false,
											'alt' => __('Move Up')
										)
									);
									?>
								</li>
								<li>
									<?php
									echo $this->Html->link(
										'<i class="icon-arrow-down"></i>',
										array(
											'controller' => 'menu_categories',
											'action' => 'move_down',
											'admin' => true,
											$location_id,
											$menu['Menu']['id'],
											$menu_category['MenuCategory']['id']
										),
										array(
											'escape' => false,
											'alt' => __('Move Down')
										)
									);
									?>
								</li>
							</ul>
							<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
								<thead>
									<th><?php echo __('Image'); ?></th>
									<th><?php echo __('Name'); ?></th>
									<th><?php echo __('Price'); ?></th>
									<th><?php echo __('Status'); ?></th>
									<th class="actions"><?php echo __('Actions'); ?></th>
								</thead>
								<tbody>
									<?php foreach ($menu_category['MenuItem'] as $menu_item): ?>
										<tr>
											<td><?php echo $this->Image->out($menu_item['image']); ?></td>
											<td>
												<?php echo h($menu_item['name']); ?>
												<?php if ($menu_item['has_options']): ?>
												<span title="<?php echo __('Has Options'); ?>">
													<i style="float:right;" class="icon-tag"></i>
												</span>
												<?php endif; ?>
											</td>
											<td><?php echo $this->Number->currency($menu_item['price'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?></td>
											<td>
												<?php
												switch ($menu_item['status']) {
													case 'active':
														$text = __('Active');
														$class = 'success';
													break;

													default:
														$text = __('Inactive');
														$class = 'error';
													break;
												}
												echo $this->Bootstrap->badge($text, $class);
												?>
											</td>
											<td>
												<?php
													echo $this->Html->link(
														__('Edit'),
														array(
															'controller' => 'menu_items',
															'action' => 'edit',
															$location_id,
															$menu_category['Menu']['id'],
															$menu_category['MenuCategory']['id'],
															$menu_item['id'],

														)
													);
												?>

												<?php
													echo $this->Form->postLink(
														__('Delete'),
														array(
															'controller' => 'menu_items',
															'action' => 'delete',
															$location_id,
															$menu_category['Menu']['id'],
															$menu_category['MenuCategory']['id'],
															$menu_item['id'],

														),
														null,
														__('Are you sure you want to delete %s?', $menu_item['name'])
													);
												?>
												<?php
												echo $this->Html->link(
													'<i class="icon-arrow-up"></i>',
													array(
														'controller' => 'menu_items',
														'action' => 'move_up',
														'admin' => true,
														$location_id,
														$menu['Menu']['id'],
														$menu_category['MenuCategory']['id'],
														$menu_item['id']
													),
													array(
														'escape' => false,
														'alt' => __('Move Up')
													)
												);

												echo $this->Html->link(
													'<i class="icon-arrow-down"></i>',
													array(
														'controller' => 'menu_items',
														'action' => 'move_down',
														'admin' => true,
														$location_id,
														$menu['Menu']['id'],
														$menu_category['MenuCategory']['id'],
														$menu_item['id']
													),
													array(
														'escape' => false,
														'alt' => __('Move Down')
													)
												);
												?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php
echo $this->Html->script('admin_menu_view');