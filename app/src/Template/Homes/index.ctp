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
			<blockquote>
				<p>
					Property Management Software Online
				</p> <small>Someone famous <cite>Source Title</cite></small>
			</blockquote>
			<div class="carousel slide" id="carousel-518631">
				<ol class="carousel-indicators">
					<li class="active" data-slide-to="0" data-target="#carousel-518631">
					</li>
					<li data-slide-to="1" data-target="#carousel-518631">
					</li>
					<li data-slide-to="2" data-target="#carousel-518631">
					</li>
				</ol>
				<div class="carousel-inner">
					<div class="item active">
						<img alt="" src="http://lorempixel.com/1600/500/sports/1" />
						<div class="carousel-caption">
							<h4>
								First Thumbnail label
							</h4>
							<p>
								Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
							</p>
						</div>
					</div>
					<div class="item">
						<img alt="" src="http://lorempixel.com/1600/500/sports/2" />
						<div class="carousel-caption">
							<h4>
								Second Thumbnail label
							</h4>
							<p>
								Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
							</p>
						</div>
					</div>
					<div class="item">
						<img alt="" src="http://lorempixel.com/1600/500/sports/3" />
						<div class="carousel-caption">
							<h4>
								Third Thumbnail label
							</h4>
							<p>
								Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
							</p>
						</div>
					</div>
				</div> <a class="left carousel-control" href="#carousel-518631" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-518631" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
			</div>
			<div class="jumbotron">
				<h1>
					Top .... ?
				</h1>
				<p>
					This is a Property management template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.
				</p>
				<p>
					<a class="btn btn-primary btn-large" href="#">Learn more</a>
				</p>
			</div>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-4 column">
			<h2>
				Heading
			</h2>
			<p>
				Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
			</p>
			<p>
				<a class="btn" href="#">View details »</a>
			</p>
		</div>
		<div class="col-md-4 column">
			<h2>
				Heading
			</h2>
			<p>
				Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
			</p>
			<p>
				<a class="btn" href="#">View details »</a>
			</p>
		</div>
		<div class="col-md-4 column">
			<h2>
				Heading
			</h2>
			<p>
				Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
			</p>
			<p>
				<a class="btn" href="#">View details »</a>
			</p>
		</div>
	</div>
</div>s