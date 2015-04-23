<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP Helper
 * @author pechartrand
 */
class BreadCrumbsCustomHelperHelper extends AppHelper {

//	public $helpers = array();
//	public $settings = null;
//	public $view = null;
//
//	function __construct($settings) {
//		$this->settings = $settings;
//
//		$this->view = ClassRegistry::getObject('view');
//	}
//
//	function beforeRender() {
//		
//	}
//
//	function afterRender() {
//		
//	}
//
//	function beforeLayout() {
//		
//	}
//
//	function afterLayout() {
//		
//	}

	/**
	 * 
	 * @param string	$activeBreadCrumb	Which crumb is active (crumb title)
	 * @param string	$root
	 * @return string
	 */
	public function show($activeBreadCrumb, $root) {

		$crumbs = $this->Session->read('Breadcrumbs');
		$i = 0;

		if ($this->Session->check('Breadcrumbs')) {
			$result = "
			<ul class='nav'>
				<li>" .
				$this->Html->link($root, '/') . "
				</li>
				<li>
					<a><i class='icon-forward'></i></a>
				</li>";

			foreach ($crumbs as $crumb) {
				$activeBreadCrumb = (!empty($activeBreadCrumb)) ? $activeBreadCrumb : '';
				$activeClass = ($activeBreadCrumb === $crumb['Title']) ? 'active' : '';
				$breadCrumUrlArray = array(
					'controller' => $crumb['Controller'],
					'action' => $crumb['Action']);
				if (!empty($crumb['Parameter'])) {
					if (is_array($crumb['Parameter'])) {
						$breadCrumUrlArray = array_merge($breadCrumUrlArray, $crumb['Parameter']);
					} else {
						array_push($breadCrumUrlArray, $crumb['Parameter']);
					}
				}
				$result .=
					"<li class='" . $activeClass . "'>" .
					$this->Html->link(
						$crumb['Title'], $breadCrumUrlArray)
					. "</li>";
				if (++$i < count($crumbs)) {
					$result .= "										
					<li>
						<a><i class='icon-forward'></i></a>
					</li>
					";
				}

				$result .= "</ul>";
			}
		} else {
			$result = '';
		}

		return $result;
	}

}
