<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> 
					 <span class="sr-only">Toggle navigation</span>
					 <span class="icon-bar"></span>
					 <span class="icon-bar"></span>
					 <span class="icon-bar"></span>
					 </button> 
					 
					 <a class="navbar-brand">
					<?php echo $this->Html->link(
                    $this->Html->image('home_page/logobuildmax1.png', array("alt" => "Property",
                    "title" => "Property", "width"=>"110px", "height" => "50px")),
                    '/',
                    array(
                        'escape' => false
                    )
                    ); ?> 
					 
					 </a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input class="form-control" type="text" />
						</div> <button type="submit" class="btn btn-default">Submit</button>
					</form>
					<ul class="nav navbar-nav navbar-right">

					    <li class="dropdown" id="menu1">
                      		<a class="dropdown-toggle" data-toggle="dropdown" href="#menu1"><?php echo __('Sign In'); ?></a>
                        	<div class="dropdown-menu">
                            	<?php echo $this->Form->create('User', array('role' => 'form', 'class' => 'form-signin', 'action' => 'login')); ?>
                                <div class="form-group">
                                    <?php echo $this->Form->input('User.email', array(
                                        'label' => false,
                                        'type' => 'email',
                                        'class' => 'form-control',
                                        'id' => 'email',
                                        'autocomplete' => 'on',
                                        'required' => 'required',
                                        'placeholder' => __('Email Address')
                                    )); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $this->Form->input('User.password', array(
                                        'label' => false,
                                        'class' => 'form-control',
                                        'id' => 'pwd',
                                        'autocomplete' => 'on',
                                        'required' => 'required',
                                        'placeholder' => __('Password')
                                    )); 
                                    echo $this->Form->hidden('login_referer', array(
                                        'value' => $this->request->referer(true)));
                                    ?>
                                </div>
                                <div class="form-group text-center">
                                <?php echo $this->Html->link(
                                    __('Forgot Password'),
                                    array(
                                        'controller' => 'users',
                                        'action' => 'forgot_password'
                                    )
                                ); ?>
                                </div>
                               
                            <?php echo $this->Form->submit(__('Login'), array(
                                'class' => 'btn btn-lg btn-primary btn-block',
                            )); ?>
                            <?php echo $this->Form->End(); ?>

                       </div>
                     </li>

                     <?php // else: ?>

                     	<li> 

                     	</li>

						<li>
							  <?php
                   // if (!$user_id) 
                   // {
                       echo '<a href="#" class="" data-toggle="modal" data-target="#registerModal">'. __("Register") . '</a>';
                    // } else { 
                    	
                    /*    echo $this->Html->link(
                            __('Logout'). ' <b class="ion-log-out" data-pack="default" data-tags="sign out" style="display: inline-block;"></b>', 
                            array(
                                'controller' => 'users',
                                'action'     => 'logout',
                                'admin'      => false
                            ), 
                            array(
                                'escape' => false)
                            ); 
                        } */
                       
                       ?>

						</li>
						<li>
							<a href="#">Francais</a>
						</li>

						<? // php if (!$user_id): ?>
						<li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong class="caret"></strong></a>
							<ul class="dropdown-menu">

								<li>
									<a href="http://test.dev/users">Users</a>
								</li>
								<li>
									<a href="http://test.dev/groups">Groups</a>
								</li>
								<li>
									<a href="http://test.dev/tenants">Tenants</a>
								</li>
								<li>
									<a href="http://test.dev/tenants">Applicants</a>
								</li>
								<li>
									<a href="http://test.dev/properties">Properties</a>
								</li>
								<li>
									<a href="http://test.dev/rental_owners">Rental Owners</a>
								</li>
								<li>
									<a href="http://test.dev/units">Units</a>
								</li>
								<li>
									<a href="http://test.dev/states">States</a>
								</li>
								<li>
									<a href="http://test.dev/countries">Countries</a>
								</li>
								<li>
									<a href="http://test.dev/cities">Cities</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="http://test.dev/aboutus">About us</a>
								</li>
								<li>
									<a href="#">Accounting</a>
								</li>
								<li>
									<a href="http://test.dev/applications_leases">Leasing</a>
								</li>
								<li>
									<a href="http://test.dev/leasestypes">Leasing type</a>
								</li>
								<li>
								   <a href="EmploymentAndIncomeHistoryController">Employment History</a>
								</li>
								<li>
								<a href="#"> Properties types specifications</a>
								</li>
								<li>
								<a href="#"> Properties types </a>
								</li>
							</ul>
						</li>
						<li>

						<li>
								 
						   <li>
						   		<div class="social">
                               <?php echo $this->Html->link(
                       			 '<i class="fa fa-lg fa-facebook"></i>','http://facebook.com/topmenuweb',
                        array(
                            'target' => '_blank',
                            'escape' => false
                        )
                    ); ?>
    	                   </div>
						   </li>

						   <li>
							   <div class="social">
 								<?php echo $this->Html->link(
                      			  '<i class="fa fa-lg fa-twitter"></i>',
                       					 'http://twitter.com/buildmaxuweb',
                        			array(
                           			 'target' => '_blank',
                            			'escape' => false
                        			)
                    					); ?>
                    					</div>
                           </li>
						   
						   <li>
						 	    <div class="social">
 				              <?php echo $this->Html->link(
                       			 '<i class="fa fa-lg fa-google-plus"></i>',
                      				  'http://googleplus.com/topmenuweb',
                       					 array(
                       				     'target' => '_blank',
                        				    'escape' => false
                        					)
                 					   ); ?>
                     			</div>
					 	    </li>

						</li>
					</ul>
				</div>
				
			  </nav>
		   </div>
	    </div>
    </div>

