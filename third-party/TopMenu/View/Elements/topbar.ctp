<!-- Fixed navbar -->
<div class="containter-100 container-topbar">
  <div class="container">
      <div style="height: 30px; width: 100%;">
        <nav class="navbar navbar-custom">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>     
                
              </div>

              <div class="nav navbar-nav navbar-left" itemscope itemtype="http://schema.org/Organization">
              	
              		<?php echo $this->Html->link(
                        $this->Html->image('home_page/topmenu.png', array("alt" => "Top Menu", "title" => "Top Menu", "itemprop"=>"logo", 'class' => 'pull-left img-responsive logo')),
                        '/',
                        array(
                            'escape' => false,
			     "itemprop"=> "url"
                        )
                    ); ?>  
              	
              </div>
              <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                  
                    <?php
            					echo $this->element('top_bar_content');
            				?>
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
      </div>  


      <?php if ($this->Session->read('Order')): ?>
        <nav class="navbar navbar-default navbar-second pull-right">
          
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">

                <li style = 'z-index:2;'>
                    <?php
                    echo $this->Html->link(
                        "<h1 class='ion-bag'> <small id='topBarTotal'>$ ". $this->Session->read('Order.Order.total'). "</small></h1>",
                        $this->Session->read('Location.url'),
                        [
                          'escape' => false
                        ]
                      
                    );
                    ?>
                </li>

            </ul>
          </div><!--/.nav-collapse -->
        </nav>
      <?php endif ?>






  </div>

  <?php
  if ($admin) :
    echo $this->element('admin_menu');
  endif; ?>
</div>  

