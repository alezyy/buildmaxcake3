<?php echo $this->Html->css('rateit.css', null, array('block' => 'css'));?>

<span class="rateit" data-rateit-value="<?php echo $stars ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></span>

<?php echo $this->Html->script('jquery.rateit.min.js'); ?>
<?php echo $this->Js->writeBuffer(); ?>
