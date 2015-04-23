<?php
/**
 *   _____                                                                       
 *  /__   \  ___   _ __     /\/\    ___  _ __   _   _      ___   ___   _ __ ___  
 *    / /\/ / _ \ | '_ \   /    \  / _ \| '_ \ | | | |    / __| / _ \ | '_ ` _ \ 
 *   / /   | (_) || |_) | / /\/\ \|  __/| | | || |_| | _ | (__ | (_) || | | | | |
 *   \/     \___/ | .__/  \/    \/ \___||_| |_| \__,_|(_) \___| \___/ |_| |_| |_|
 *                |_|                                                                                           
 *               
 * @copyright     Copyright (c) Top Menu Web, Inc. (https://www.topmenu.com) & Respective Owners
 * @link          https://www.topmenu.com/ Top Menu Web Inc.
 * @version 	  2
 *                                                                   
 */

App::uses('HtmlHelper', 'View/Helper');
App::uses('View', 'View');
App::uses('Component', 'Controller');
/**
 * AjaxRedirectComponent class.
 *
 * @extends Component
 */
class AjaxRedirectComponent extends Component {


	public function redirectIfUnAuthed(Controller &$controller, $force = false) {
		if (!$controller->Auth->user('id') || $force) {
			$view = new View($controller);
			$htmlHelper = new HtmlHelper($view);
			$code = '
			var l = window.location;
			var base_url = l.protocol + "//" + l.host + "/";
			window.location.replace(base_url);';
			echo $htmlHelper->scriptBlock($code, array('inline' => true));
			exit;
		}
	}

}