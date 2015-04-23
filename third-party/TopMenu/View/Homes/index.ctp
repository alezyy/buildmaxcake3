    <nav class="navbar navbar-custom hidden-xs ">
        <div class="container-fluid">
          <div class="navbar-header">
            <div class="row logo" itemscope itemtype="http://schema.org/Organization">   
                <?php echo $this->Html->link(
                    $this->Html->image('home_page/topmenu.png', array("alt" => "Top Menu", "title" => "Top Menu", "itemprop"=>"logo", 'class' => 'pull-left img-responsive')),
                    '/',
                    array(
                        'escape' => false,
                        "itemprop"=> "url"
                    )
                ); ?>
                <div class="pull-right hidden-xs hidden-sm">
                    <h4><?php echo __('Order online'); ?></h4>
                    <p><?php echo __('Montréal, Laval, Rive-Nord, Rive-Sud'); ?><p/>
                </div>       
            </div> 
            
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              
                <?php if ($this->Session->read('Order')): ?>
                    <li>
                        <?php echo $this->Html->link(
                            " $".$this->Session->read('Order.Order.total'),
                            $this->Session->read('Location.url'),
                            [
                              'escape' => false,
                              'icon' => 'ion-bag'
                            ]
                          
                        );
                        ?>
                    </li>
                <?php endif ?>

                <?php if (!$user_id): ?>
                       
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
                            'escape' => false));

                endif; ?>

                </li>

                <li>
                    <?php
                    if (!$user_id) {
                        echo '<a href="#" class="" data-toggle="modal" data-target="#registerModal">'. __("Register") . '</a>';
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
        </div><!--/.container-fluid -->
    </nav>

    <!--/.Mobile Nav bar -->
    <nav class="navbar navbar-custom visible-xs text-center">
        <div class="container-fluid">
          <div class="navbar-header">
            <div class="row logo">   
                <?php echo $this->Html->link(
                    $this->Html->image('home_page/topmenu.png', array("alt" => "Top Menu", "title" => "Top Menu", 'class' => 'pull-left img-responsive')),
                    '/',
                    array(
                        'escape' => false
                    )
                ); ?>
                <button id="navbar-button" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar top-bar"></span>
                  <span class="icon-bar middle-bar"></span>
                  <span class="icon-bar bottom-bar"></span>
                </button>    
            </div> 
            
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              
                <?php if (!$user_id): ?>
                       
                    <li>

                        <?php echo $this->Html->link(
                                    __('Login'), array(
                                    'controller' => 'users',
                                    'action'     => 'login',
                                    'admin'      => false),
                                    array(
                                    'escape' => false));

                        ?>

                <?php else: ?>



                    <?php echo $this->Html->link(
                            __('My Account'). ' <b class="ion-person" data-pack="default" data-tags="users, staff, head, human" style="display: inline-block;"></b>', array(
                            'controller' => 'users',
                            'action'     => 'my_account',
                            'admin'      => false),
                            array(
                            'escape' => false));

                endif; ?>

                </li>

                <li>
                    <?php
                    if (!$user_id) {
                        echo '<a href="#" class="" data-toggle="modal" data-target="#registerModal">'. __("Register") . '</a>';
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
                <li>
                    <a href="<?php echo $this->request->here; ?>" onclick="document.cookie = 'siteversion=mobile;path=/';">
                        <i class="icon-home" style="margin-right:3px;"></i><?php echo __('Mobile site') ?></a>
                </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>

    <!-- Begin page content -->
    <div class="container-100">
        <div class="row container-100 no-padding">
            <div class="col-xs-12 col-md-4 col-lg-3 pull-left container" id="form">
                <h2 class="text-right"><?php echo __(' Find a menu'); ?></h2>
                <h4 class="text-right"><?php echo __('that suits you'); ?></h4>
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
                                'after' => '<span class="input-group-btn pull-left">
                                                <button class="geolocation btn btn-default" type="button" onclick="getLocation();" data-toggle="tooltip" data-placement="bottom" title="'.__('Use my current location').'">
                                                        <i class="ion-pinpoint"></i>
                                                </button>
                                            </span>',
                                'div'       => 'entry input-group col-xs-9 pull-left',
                                'no_div'    => TRUE,
                                'class'     => 'text-center col-xs-12',
                                'maxlength' => 3,
                                'style'     => 'text-transform: uppercase;',
                                'tabindex'  => 1,
                                'type'      => 'text'));

                        echo $this->Form->submit('GO !', array(
                                'class' => 'btn btn-primary col-xs-12', 
                                'id' => 'postalCodeSubmit',
                                'label' => 'd',
                                'div' => 'col-xs-3 no-padding'));

                    echo $this->Form->End();
                ?>
            </div>
            <div class="hidden-xs col-md-4 col-lg-4 pull-right text-right" id="steps">
                <a href="/<?php echo $langSuffix ?>/faq"> 
                    <h2 class="text-red">
                        <span class=""><?php echo __('How does'); ?></span><br/>
                        <span class=""><?php echo __('it work?'); ?></span>
                    </h2>
                    <div class="col-xs-10">
                        <h1><strong><?php echo __('1.'); ?></strong></h1>
                        <p><?php echo __('Enter your postal code'); ?></p>
                    </div>
                    <div class="col-xs-2">
                        <?php echo $this->Html->image('home_page/code-postal.png', array(
                                'width' => 'auto',
                                'height' => 70,
   				"alt" => "Code postal",
				"title" => "Code postal"
                            )
                        ); ?>
                    </div>
                    <div class="col-xs-10">
                        <h2><strong><?php echo __('2.'); ?></strong></h2>
                        <p><?php echo __('Choose a restaurant'); ?></p>
                    </div>
                    <div class="col-xs-2">
                        <?php echo $this->Html->image('home_page/choix.png', array(
                                'width' => 'auto',
                                'height' => 70,
				"alt" => "Choix"
                            )
                        ); ?>
                    </div>   
                    <div class="col-xs-10">
                        <h3><strong><?php echo __('3.'); ?></strong></h3>
                        <p><?php echo __('Confirm your order'); ?></p>
                    </div>
                    <div class="col-xs-2">
                        <?php echo $this->Html->image('home_page/commande.png', array(
                                'width' => 'auto',
                                'height' => 70,
				"alt" => "Commande"
                            )
                        ); ?>
                    </div>
                </a>     
            </div>
        </div>
    </div>
    <div class="container-100 hidden-xs" style="position: absolute; bottom: 80px; padding: 0px 45px;">
        <?php echo $this->Html->image('home_page/photo.png', array(
            "alt" => "Top Menu", 
            "title" => "Top Menu", 
            'class' => 'pull-left',
            'width' => 'auto',
            'height' => 110)
        ); ?>
        <?php echo $this->Html->link(
            $this->Html->image('home_page/aide.png', array(
                "alt" => __("Need Help"), 
                "title" => __("Need Help"), 
                'class' => 'pull-right',
                'width' => 'auto',
                'height' => 110)
            ),
            array(
                'controller' => 'pages',
                'action' => 'popupex.html'
            ),
            array(
                'escape' => false,
                'class' => 'shake-me',
                'onclick' => "return popitup('http://www.providesupport.com/?messenger=topmenuweb')"
            )
        ); ?>
    </div>

    <footer class="footer hidden-xs hidden-sm">
      <div class="text-center">
        <ul class="list-inline menu">
            <li id="menu-cuisines">
                <?php echo $this->Html->link(
                   'Cuisines <span class="caret"></span>',
                    '#',
                    array(
                        'escape'=>false  //NOTICE THIS LINE ***************
                    )
                ); ?>
            </li>
            <li id="menu-secteurs">
                <?php echo $this->Html->link(
                   __('Neighborhoods'). ' <span class="caret"></span>',
                    '#',
                    array(
                        'escape'=>false  //NOTICE THIS LINE ***************
                    )
                ); ?>
            </li>


            <li itemscope itemtype="http://schema.org/AboutPage">
                <?php
                echo $this->Html->link(
                    __('About us'), array(
                    'controller' => 'pages',
                    'action'     => 'about_us'),
		    array('itemprop' => 'url' ));
                ?>  
            </li>
            
            <li itemscope itemtype="http://schema.org/ContactPage">
                <?php
                echo $this->Html->link(
                    __('Contact-Us'), array(
                    'controller' => 'contacts',
                    'action'     => 'index'),
                     array('itemprop' => 'url' ));
                ?>
            </li>
            
            <li itemscope itemtype="http://schema.org/WebPage">
                <?php
                echo $this->Html->link(
                    __('Add your restaurant'), array(
                    'controller' => 'restaurants',
                    'action'     => 'add_restaurant',
                    'language'     => $langSuffix),
		     array('itemprop' => 'url')
                      );
                ?>
            </li>
            
            <li itemscope itemtype="http://schema.org/WebPage">
                <?php
                echo $this->Html->link(
                    __('Privacy and Terms'), array(
                    'controller' => 'pages',
                    'action'     => 'display',
                    'escape'     => false,
                    'terms'),
                    array('itemprop' => 'url')
                      );
                ?>
            </li>   
            
            <li itemscope itemtype="http://schema.org/WebPage">
                <?php  echo $this->Html->link(__("Sitemap"), array('controller' => 'pages', 'action' => 'sitemap'),
                         array('itemprop'=> 'url')); ?>
            </li>

            <li>
               

                <a href="<?php  echo $this->request->here; ?>" onclick="document.cookie = 'siteversion=mobile;path=/';">
                    <i class="icon-home" style="margin-right:3px;"></i><?php echo __('Mobile site') ?></a>
            </li>
        </ul>
        <ul class="list-group row" id="cuisines" style="display:none;">

            <li class="list-group-item col-xs-12">
                <?php
                    echo $this->Html->link(__("All cuisines types"), 
                        Router::url(
                            [
                                'controller' => 'cuisines',
                                'action' => 'view',
                                'language' => $langSuffix
                            ]
                        )
                    );
                ?>
            </li>

            <?php foreach ($cuisines as $cuisine): ?>
                <li class="list-group-item col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <?php
                    echo $this->Html->link(
                        __($cuisine['Cuisine']['name']),
                       Router::url(
                            [
                                'controller' => 'cuisines',
                                'action' => 'search',
                                'cuisine' => $cuisine['Cuisine']['url'],
                                'language' => $langSuffix
                            ]
                        )
                    );
                    ?>
                </li>
            <?php endforeach; ?>    
        </ul>
        
        <ul class="list-group row" id="secteurs" style="display:none;">

            <li class="list-group-item col-xs-12">
                <?php
                    echo $this->Html->link(__("All sectors"), 
                        Router::url(
                            [
                                'controller' => 'sectors',
                                'action' => 'view',
                                'language' => $langSuffix
                            ]
                        )
                    );
                ?>
            </li>

            <?php foreach ($sectors as $sector): ?>
                <li class="list-group-item col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <?php echo $this->Html->link(
                            __($sector['Sector']['name']),
                            Router::url(
                                [
                                    'controller' => 'locations',
                                    'action' => 'search',
                                    'language' => $langSuffix,
                                    'nh' => $sector['Sector']['url']
                                ]
                            )
                        ); 
                    ?>
                </li>
            <?php endforeach; ?>    
        </ul>
      </div>
    </footer>  

    <!-- Mobile Footer -->
    <footer class="footer visible-xs visible-sm mobile-footer">
      <div class="text-center visible-xs">
        <p><?php echo __('Top Menu Web Inc. 2013') ?></p>
      </div>
      <div class="text-center visible-sm">
        <ul class="list-inline menu">
            <li>
                <?php
                echo $this->Html->link(
                    __('About us'), array(
                    'controller' => 'pages',
                    'action'     => 'about_us'));
		
                ?>  
            </li>
            
            <li>
                <?php
                echo $this->Html->link(
                    __('Contact-Us'), array(
                    'controller' => 'contacts',
                    'action'     => 'index'));
                ?>
            </li>
            
            <li>
                <?php
                echo $this->Html->link(
                    __('Add your restaurant'), array(
                    'controller' => 'restaurants',
                    'action'     => 'add_restaurant',
                    'language'     => $langSuffix));
                ?>
            </li>
            
            <li>
                <?php
                echo $this->Html->link(
                    __('Privacy and Terms'), array(
                    'controller' => 'pages',
                    'action'     => 'display',
                    'escape'     => false,
                    'terms'));
                ?>
            </li>   
            
            <li>
                <?php echo $this->Html->link(__("Sitemap"), array('controller' => 'pages', 'action' => 'sitemap')); ?>
            </li>
        </ul>
      </div>

    </footer>  

    <?php echo $this->element('register'); ?>
    <?php echo $this->element('postal_code_modal'); ?>
