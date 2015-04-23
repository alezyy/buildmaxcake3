<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset('utf-8'); ?>
    <title>
        <?php echo $title_for_layout; ?>
    </title>

    <?php 
    
    // CSS
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('ionicons.min');
    echo $this->Html->css('font-awesome.min');
    echo $this->Html->css('spinner');
    echo $this->Html->css("//fonts.googleapis.com/css?family=Open+Sans:700,400' rel='stylesheet' type='text/css'>");
    echo $this->Html->css('style');
    
    echo $this->fetch('css');
    
    // Canonicals
    echo $this->element('canonicals');
    ?>
    
    <!-- Apple icons -->
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png"/>
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png"/>
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png"/>
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png"/>
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png"/>
    <link rel="icon" type="image/png" href="/favicon-196x196.png" sizes="196x196"/>
    <link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160"/>
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96"/>
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" sizes="16x16"/>
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32"/>
    <meta name="msapplication-TileColor" content="#da532c"/>
    <meta name="msapplication-TileImage" content="/mstile-144x144.png"/>
    <meta name="google-site-verification" content="v4lGo8dQ5cL2se8tOCGwUa1NkDfNMCIn66yAQ99aekU" />
        
</head>
<body>

   

    <?php echo $this->element('no_script'); 
        echo $this->element('spinner');?>
     

     <?php echo $this->element('topbar_pages'); ?> 

     <div class="container container-body">
        <?php 
        echo $this->Session->flash('auth');
        echo $this->Session->flash();
        echo $content_for_layout; ?>
    </div>

    <?php echo $this->element('footer_pages'); ?> 


    <?php
    // JS
    echo $this->Html->script('jquery');
    echo $this->Html->script('jquery.validate.min');
    echo $this->Html->script('validate.custom');
    echo $this->Html->script('bootstrap.min');
    echo $this->Html->script('jquery.modernizr');
    echo $this->Html->script('home');
    echo $this->element('password_meter');
    echo $this->Html->script('password_meter', array('inline' => false));
    echo $this->Html->script('dropdown-login');
    echo $this->Js->writeBuffer();
    echo $this->fetch('script');
    ?>
</body>
</html>