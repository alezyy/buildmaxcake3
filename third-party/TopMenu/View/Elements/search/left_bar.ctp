<div class="col-xs-12 col-md-3 pull-left sidebar-parent sidebar-left">
	<div class="sidebar col-xs-12">
		<h1 class="page-header text-red"><strong><?php echo __('Search'); ?></strong></h1>

		<div class="list-group">
			<?php
                echo $this->Form->create(
                    'Location', array(
                    'class' => 'form-inline',
                    'url'   => array(
                        'controller' => 'locations',
                        'action'     => 'search'
                    ),
                    'id'    => 'delivery'
                    )
                );
                echo $this->Form->input('postal_code1', array(
                        'label'     => __('Enter your postal code'), array('class'=>'text-red'),
                        'placeholder' => 'H0H',
                        'div'       => FALSE,
                        'no_div'    => TRUE,
                        'class'     => 'text-center col-xs-12 col-md-8',
                        'maxlength' => 3,
                        'style'     => 'text-transform: uppercase;',
                        'tabindex'  => 1,
                        'type'      => 'text'));

                    echo $this->Form->submit('GO !', array('class' => 'btn btn-primary col-xs-12 col-md-4', 'id' => 'postalCodeSubmit'));

                echo $this->Form->End();
            ?>
        </div><br/><br/>

	    <div class="page-header">
			<h4 class=""><?php echo __('Cuisines'); ?></h4>
		</div>

		<?php  ?>
		<ul class="list-group scrollbar">
				

	        <?php if ($this->request->params['pc']): ?>
	        	<li>
		        	<?php echo $this->Html->link(
		                    __('ALL'),
		                    array(
					        	'controller' => 'locations',
					        	'action' => 'search',
					        	'language' => $langSuffix,
					        	'pc' => $this->request->params['pc']
					        ),
					        array(
					        	'class' => ($this->request->params["pass"] == null) ? 'active' : ''
					        )
		                );
		            ?>
		        </li>

			    <?php foreach ($cuisines as $key => $cuisine): ?>

			        <li>
			        	<?php echo $this->Html->link(
			                    $cuisine,
			                    Router::url(
			                        [
			                            'controller' => 'locations',
			                            'action' => 'search',
			                            'pc' => $this->request->params['pc'],
			                            'language' => $langSuffix,
			                            'cuisine' => Inflector::slug($cuisine, '-')
			                        ]
			                    ),
						        [
						        	'class' => isset($this->request->params["pass"][0]) && ($this->request->params["pass"][0] == $cuisine) ? 'active' : ''
						        ]
			                );
			            ?>
			        </li>

			    <?php endforeach; ?> 
			<?php elseif(($this->request->params['nh'])): ?>
				
				<li>
		        	<?php echo $this->Html->link(
		                    __('ALL'),
		                    array(
					        	'controller' => 'locations',
					        	'action' => 'search',
					        	'language' => $langSuffix,
					        	'nh' => $this->request->params['nh']
					        ),
					        array(
					        	'class' => ($this->request->params["pass"] == null) ? 'active' : ''
					        )
		                );
		            ?>
		        </li>

				<?php foreach ($cuisines as $key => $cuisine): ?>

			        <li>
			        	<?php echo $this->Html->link(
			                    $cuisine,
			                    Router::url(
			                        [
			                            'controller' => 'locations',
			                            'action' => 'search',
			                            'nh' => $this->request->params['nh'],
			                            'language' => $langSuffix,
			                            'cuisine' => strtolower(Inflector::slug($cuisine, '-'))
			                        ]
			                    ),
						        [
						        	'class' => isset($this->request->params["pass"][0]) && ($this->request->params["pass"][0] == $cuisine) ? 'active' : ''
						        ]
			                );
			            ?>
			        </li>

			    <?php endforeach; ?> 
			<?php endif; ?>  
	    </ul>

	    

	    
		<?php
		// echo $this->Html->script('search_selector', array('inline' => false));
		// echo $this->Html->script('search_box', array('inline' => false));

		?>
	</div>
</div><!--/left-->

<?php echo $this->element('postal_code_modal'); ?>
