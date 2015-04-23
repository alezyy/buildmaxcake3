<!-- Fixed navbar -->
<div class="container-topbar container">
    <nav class="navbar navbar-custom">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>     
            
          </div>

          <div class="nav navbar-nav navbar-left">
          	
          		<?php echo $this->Html->link(
                    $this->Html->image('home_page/topmenu.png', array("alt" => "Top Menu", "title" => "Top Menu", 'class' => 'pull-left img-responsive logo')),
                    '/',
                    array(
                        'escape' => false
                    )
                ); ?>  
          	
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              
                <?php if (!$user_id): ?>
                       
                  <li class="dropdown" id="menu1">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu1"><?php echo __('Sign In'); ?></a>
                      <div class="dropdown-menu">
                          <?php echo $this->Form->create('User', array('role' => 'form', 'class' => 'form-signin', 'action' => 'login', )); ?>
                              <div class="form-group">
                                  <?php echo $this->Form->input('User.email', array(
                                      'label' => false,
                                      'type' => 'email',
                                      'class' => 'form-control',
                                      'id' => 'email',
                                      'autocomplete' => 'off',
                                      'required' => 'required',
                                      'placeholder' => __('Email Address')
                                  )); ?>
                              </div>
                              <div class="form-group">
                                  <?php echo $this->Form->input('User.password', array(
                                      'label' => false,
                                      'class' => 'form-control',
                                      'id' => 'pwd',
                                      'autocomplete' => 'off',
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
                              <!-- Facebook Login
                              <div class="form-group text-center">
                                <p><?php echo __('Or Sign in with'); ?></p>
                              </div>
                              <ul class='list-inline form-group text-center'>
                                <li><a href=""><h1 class="ion-social-facebook" data-pack="social" data-tags="like, post, share" style="display: inline-block;"></h1></a></li>
                                <li><a href=""><h1 class="ion-social-googleplus" data-pack="social" data-tags="like, post, share" style="display: inline-block;"></h1></a></li>
                              </ul> -->
                          <?php echo $this->Form->submit(__('Login'), array(
                              'class' => 'btn btn-lg btn-primary btn-block',
                          )); ?>
                          <?php echo $this->Form->End(); ?>
                     </div>
                   </li>
              <?php else: ?>

                  <li>

                  <?php echo $this->Html->link(
                              __('My Account'). ' <b class="ion-person" data-pack="default" data-tags="users, staff, head, human" style="display: inline-block;"></b>', array(
                              'controller' => 'users',
                              'action'     => 'my_account',
                              'admin'      => false),
                              array(
                              'escape' => false)); ?>
                  </li>
              <?php endif; ?>
                  <li>
                    <?php
                      if (!$user_id) {
                          echo $this->Html->link(
                              __('Register'), array(
                              'controller' => 'users',
                              'action'     => 'register',
                              'admin'      => false));
                      } else {
                          echo $this->Html->link(
                              __('Logout'). ' <b class="ion-log-out" data-pack="default" data-tags="sign out" style="display: inline-block;"></b>', 
                              array(
                                  'controller' => 'users',
                                  'action'     => 'logout',
                                  'admin'      => false
                              ), 
                              array(
                                  'escape' => false)
                              );
                      }
                    ?>
                </li>
                <li>
                  <?php
                  if ($language == 'fr') {
                      echo $this->Html->link(__('English'), '/en' . substr($this->request->here, 3));
                  } else {
                      echo $this->Html->link(__('Français'), '/fr' . substr($this->request->here, 3));
                  }
                  ?>
                </li>
                <li>
                    <?php echo $this->Html->link(
                        '<i class="ion-social-facebook" data-pack="social" data-tags="like, post, share" style="display: inline-block;"></i>',
                        'http://facebook.com/topmenuweb',
                        array(
                            'target' => '_blank',
                            'escape' => false
                        )
                    ); ?>
                </li>
                <li>
                    <?php echo $this->Html->link(
                        '<i class="ion-social-twitter" data-pack="social" data-tags="like, post, share" style="display: inline-block;"></i>',
                        'http://twitter.com/topmenuweb',
                        array(
                            'target' => '_blank',
                            'escape' => false
                        )
                    ); ?>
                </li>
                <li>
                    <?php echo $this->Html->link(
                        '<i class="ion-social-googleplus" data-pack="social" data-tags="like, post, share" style="display: inline-block;"></i>',
                        'https://plus.google.com/117928784117468568120/',
                        array(
                            'target' => '_blank',
                            'escape' => false
                        )
                    ); ?>
                </li>
            </ul>
          </div><!--/.nav-collapse -->
    </nav>

    <?php
    if ($admin) :
      echo $this->element('admin_menu');
    endif; ?>
</div>


