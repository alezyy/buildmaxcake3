<div class="row_mobile row">
    <h1><?php echo __('Write your review'); ?></h1>
</div>

<div class="row_mobile row">

    <?php echo $this->Form->create('Rating'); ?>		

    <h2><?php echo __('Rating: ') ?></h2>

    <div>
        <?php
        echo $this->Form->input('rating', array(
            'type'   => 'range',
            'step'   => '0.5',
            'no_div' => TRUE,
            'div'    => FALSE,
            'label'  => FALSE,
            'id'     => 'backing4'));
        ?>
        <div class="rateit" data-rateit-backingfld="#backing4" data-rateit-resetable="false" data-rateit-ispreset="true"
             data-rateit-min="1" data-rateit-max="5">
        </div>
    </div>
</div>

<div class="row_mobile row">
    <h2><?php echo __('Comment: ') ?></h2>

    <?php
        echo $this->Form->input('review', array(
            'div'    => false,
            'style'  => 'width: 100%',
            'no_div' => TRUE,
            'label'  => FALSE));
?>
</div>

<div class="row_mobile row">
    <h2><?php echo __('Order description'); ?></h2>

    <table>
        <tr>
            <th>
                <?php echo __('Restaurant: ') ?>
            </th><td>
                <?php echo $location_name['Location']['name']; ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo __('Ordered on: ') ?>
            </th><td>
                <?php echo $this->Date->formatDate($order['Order']['created']); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo __('Items: ') ?></th>
            <td></td>
            <?php foreach ($order['OrderDetail'] as $od) { ?>
            <tr>
                <td></td>
                <td><?php echo $od['name'] ?></td>
            </tr>

        <?php } ?>
    </table>
</div>
<?php echo $this->Form->hidden('id', array('value' => $id)); ?>
<?php echo $this->Form->hidden('status', array('value' => 'active')); ?>

<div class="row row_emphasis">
  <?php
    echo $this->Form->end(array(
        'label' => __('Submit'),
        'div' => false,
        'no_div' => true,
        'class' => 'btn btn-success',
    ));
    ?>
</div>
 
<div class="row_mobile row">
    &nbsp;
</div>

<?php echo $this->Html->css('rateit.css', null, array('block' => 'css')); ?>
<?php echo $this->Html->script('jquery.rateit.min.js'); ?>
<?php
echo $this->Js->writeBuffer();
