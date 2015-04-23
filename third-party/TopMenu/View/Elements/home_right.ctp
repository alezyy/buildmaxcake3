<?php
echo $this->Html->link(
	$this->Html->image('topmenu_ipad_contest_' . $language . '.png'),
	array(
		'controller' => 'users',
		'action' => 'register'
	),
	array(
		'title' => __('Register'),
		'escape' => false,
		'style' => 'margin-left:20px;'
	)
);