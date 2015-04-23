<div class="container-white">
    <div class="page-header">
        <h1><?php echo __('Privacy and Terms'); ?></h1>
    </div>


    <div class="row" style="padding:20px;">
        <ul class="list-group row contact">
           	<li class="list-group-item col-xs-12 col-md-4 panel panel-default text-center">
                <?php echo $this->Html->link('<i class="fa fa-lock fa-6"></i><p>'.__("Privacy Policy")."</p>", 
                        array('controller' => 'pages', 'action' => 'confidentiality'),
                        array('escape' => false)
                    );
                ?>
            </li>

            <li class="list-group-item col-xs-12 col-md-4 panel panel-default text-center">
                <?php echo $this->Html->link('<i class="fa fa-check fa-6"></i><p>'.__('Terms and Conditions of Use and Sale')."</p>", 
                        array('controller' => 'pages', 'action' => 'terms_conditions'),
                        array('escape' => false)
                    );
                ?>
            </li>

            <li class="list-group-item col-xs-12 col-md-4 panel panel-default text-center">
                <?php echo $this->Html->link('<i class="fa fa-tags fa-6"></i><p>'.__('Coupons Terms and Conditions')."</p>", 
                        array('controller' => 'pages', 'action' => 'coupons_legal'),
                        array('escape' => false)
                    );
                ?>
            </li>

        </ul>
    </div>
</div>