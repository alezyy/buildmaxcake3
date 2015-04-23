<div class="nav-wrapper">
    <div class="navbar admin_menu" id="admin_menu" data-spy="affix" data-offset-top="146">
        <div class="navbar-inner">
            <div class="container">
                <?php
                echo $this->Html->link(
                    __('Admin'), array(
                    'controller' => 'admins',
                    'action'     => 'index',
                    'admin'      => true
                    ), array(
                    'class' => 'brand'
                    )
                );
                ?>
                <ul class="nav">


                    <li class="dropdown">
                        <?php
                        echo $this->Html->link(
                            __('User Management'), array(
                            'controller' => 'users',
                            'action'     => 'index',
                            'admin'      => true
                            )
                        );
                        ?>
                    </li>


                    <li class="dropdown">
                        <?php
                        echo $this->Html->link(
                            __('Restaurants') . $this->Html->tag('b', '', array('class' => 'caret')), '#', array(
                            'data-toggle' => 'dropdown',
                            'class'       => 'dropdown-toggle',
                            'escape'      => false
                            )
                        );
                        ?>
                        <ul class="dropdown-menu" role="menu">
                            <li class="dropdown">
                            <li>
                                <?php
                                echo $this->Html->link(
                                    __('Browse Locations'), array(
                                    'controller' => 'locations',
                                    'action'     => 'index',
                                    'admin'      => true
                                    )
                                );
                                ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link(
                                    __('Cuisines'), array(
                                    'controller' => 'cuisines',
                                    'action'     => 'index',
                                    'admin'      => true
                                    )
                                );
                                ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link(
                                    __('Old URL Redirects'), array(
                                    'controller' => 'location_redirects',
                                    'action'     => 'index',
                                    'admin'      => true
                                    )
                                );
                                ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link(
                                    __('Features'), array(
                                    'controller' => 'features',
                                    'action'     => 'index',
                                    'admin'      => true
                                    )
                                );
                                ?>
                            </li>

                            <li>
                                <?php
                                echo $this->Html->link(
                                    __('Specialties'), array(
                                    'controller' => 'specialties',
                                    'action'     => 'index',
                                    'admin'      => true
                                    )
                                );
                                ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link(
                                    __('Sectors - List'), array(
                                    'controller' => 'sectors',
                                    'action'     => 'index',
                                    'admin'      => true
                                    )
                                );
                                ?>
                            </li> 
                    
                </ul>
                </li>




                <li class="dropdown">
                    <?php
                    echo $this->Html->link(
                        __('Printers') . $this->Html->tag('b', '', array('class' => 'caret')), '#', array(
                        'data-toggle' => 'dropdown',
                        'class'       => 'dropdown-toggle',
                        'escape'      => false
                        )
                    );
                    ?>
                    <ul class="dropdown-menu" role="menu">
                        <li class="dropdown">

                        <li>
                            <?php
                            echo $this->Html->link(
                                __('Dashboard'), array(
                                'controller' => 'devices',
                                'action'     => 'index',
                                'admin'      => true
                                )
                            );
                            ?>
                        </li>

                </li>
                </ul>
                </li>






                <li class="dropdown">
                    <?php
                    echo $this->Html->link(
                        __('Orders') . $this->Html->tag('b', '', array('class' => 'caret')), '#', array(
                        'data-toggle' => 'dropdown',
                        'class'       => 'dropdown-toggle',
                        'escape'      => false
                        )
                    );
                    ?>
                    <ul class="dropdown-menu">
                        <li>
                            <?php
                            echo $this->Html->link(
                                __('Browse Orders'), array(
                                'controller' => 'orders',
                                'action'     => 'index',
                                'admin'      => true
                                )
                            );
                            ?>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="goToOrderEdit()"><?php echo __('Edit an Order'); ?>

                        </li>
                        <li>
                            <?php
                            echo $this->Html->link(
                                __('Browse Transactions'), array(
                                'controller' => 'transaction_logs',
                                'action'     => 'index',
                                'admin'      => true
                                )
                            );
                            ?>
                        </li>
                        <li>
                            <?php
                            echo $this->Html->link(
                                __('Coupons'), array(
                                'controller' => 'coupons',
                                'action'     => 'index',
                                'admin'      => true
                                )
                            );
                            ?>
                        </li>
                        <li>
                            <?php
                            echo $this->Html->link(
                                __('Report'), array(
                                'controller' => 'orders',
                                'action'     => 'accounting_report',
                                'admin'      => true
                                )
                            );
                            ?>
                        </li>
                        <li>
                            <?php
                            echo $this->Html->link(
                                __('Refunds'), array(
                                'controller' => 'orders',
                                'action'     => 'refunds',
                                'admin'      => true
                                )
                            );
                            ?>
                        </li>
                    </ul>
                </li>


                <li>
                    <?php
                    echo $this->Html->link(
                        __('Taxes'), array(
                        'controller' => 'taxes',
                        'action'     => 'index',
                        'admin'      => true
                        )
                    );
                    ?>
                </li>

                </ul>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->Html->css('admin_menu');
?>

<script>
    function goToOrderEdit() {
        var result = prompt("<?php __('Please Enter Order ID'); ?>");
        if (result !== null && result !== '') {
            window.location.href = "<?php echo $this->Html->url(array('controller' => 'orders', 'action' => 'edit')); ?>/" + result;
        }
    }
</script>
