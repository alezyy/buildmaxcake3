<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset('utf-8'); ?>
    <title>
        <?php echo $title_for_layout." - Top Menu"; ?>
    </title>

    <?php 
    // Meta
    echo $this->Html->meta('icon');
    echo $meta_viewport;
    echo $meta_description;
    echo $meta_keywords;
    echo $meta_city;
    echo $meta_state;
    echo $this->fetch('meta');
    
    // CSS. This CSS file is the SASS compiled version of all the partial CSS  
    echo $this->Html->css('app');

    
    
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
     

     <?php echo $this->element('topbar'); ?> 

     <div class="container container-body">
        <?php 
        echo $this->Session->flash('auth');
        echo $this->Session->flash();
        echo $content_for_layout; ?>
    </div>

    <?php echo $this->element('footer'); ?> 


    <?php
    // JS
    echo $this->Html->script('/bower_components/jquery/dist/jquery.min');
    echo $this->Html->script('/bower_components/jquery-validation/dist/jquery.validate.min');
    echo $this->Html->script('validate.custom');
    echo $this->Html->script('/bower_components/bootstrap/dist/js/bootstrap.min');
    echo $this->Html->script('/bower_components/modernizr/modernizr');
    echo $this->Html->script('/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min');
    echo $this->Html->script('application');
    echo $this->Html->script('//maps.google.com/maps/api/js?sensor=true', false);
    echo $this->Html->script('/bower_components/bootstrap-star-rating/js/star-rating');
    echo $this->Js->writeBuffer();
    echo $this->fetch('script');
    ?>
</body>
</html>
