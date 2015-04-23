
<div class="container-white">
    <div class="page-header">
        <h1>
            <?php
            if (empty($message) && !empty($code)):
                echo __('Sorry we could not find your page (Error: %s)', $code);
            elseif (empty($message)):
                echo __('Sorry we could not find your page');
            else :
                echo $message;
            endif;
            ?>
        </h1>
    </div>
    <div class="">

        <p>
            <?php
            if (Configure::read('debug') > 0 && !empty($error)):
                echo $this->element('exception_stack_trace');
            endif;
            ?>
        </p>

            <h4>
            <?php echo __('You can search restaurants in your area:'); ?>
            </h4>

            <div class="col-xs-6">
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
                                'label'     => __('Enter your postal code'),
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
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <p></p>
                <div class="col-xs-12">
                   <p> <?php echo $this->Html->link(__('You can go back to our home page'), '/'); ?></p>
                </div>
                <div class="col-xs-12">
                   <p> <?php echo $this->Html->link(__('You can contact our customer service'), 'http://messenger.providesupport.com/messenger/ topmenuweb.html', array('target' => '_blank')); ?></p>
                </div>
            </div>
    </div>
</div>


<?php echo $this->element('postal_code_modal'); ?>
