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

/**
 * Cake E-Mail
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Network.Email
 * @since         CakePHP(tm) v 2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('CakeEmail', 'Network/Email');


/**
 * Cake e-mail class.
 *
 * This class is used for handling Internet Message Format based
 * based on the standard outlined in http://www.rfc-editor.org/rfc/rfc2822.txt
 *
 * @package       Cake.Network.Email
 */
class TopmenuEmail extends CakeEmail {



/**
 * Build and set all the view properties needed to render the templated emails.
 * If there is no template set, the $content will be returned in a hash
 * of the text content types for the email.
 *
 * @param string $content The content passed in from send() in most cases.
 * @return array The rendered content with html and text keys.
 */
	protected function _renderTemplates($content) {
		$types = $this->_getTypes();
		$rendered = array();
		if (empty($this->_template)) {
			foreach ($types as $type) {
				$rendered[$type] = $this->_encodeString($content, $this->charset);
			}
			return $rendered;
		}
		$viewClass = $this->_viewRender;
		if ($viewClass !== 'View') {
			list($plugin, $viewClass) = pluginSplit($viewClass, true);
			$viewClass .= 'View';
			App::uses($viewClass, $plugin . 'View');
		}

		$View = new $viewClass(null);
		$View->viewVars = $this->_viewVars;
		$View->helpers = $this->_helpers;

		list($templatePlugin, $template) = pluginSplit($this->_template);
		list($layoutPlugin, $layout) = pluginSplit($this->_layout);
		if ($templatePlugin) {
			$View->plugin = $templatePlugin;
		} elseif ($layoutPlugin) {
			$View->plugin = $layoutPlugin;
		}
		if ($this->_theme) {
			$View->theme = $this->_theme;
		}

		foreach ($types as $type) {
			$View->set('content', $content);
			$View->hasRendered = false;
			$View->viewPath = Configure::read('Config.language') . DS . 'Emails' . DS . $type;
			$View->layoutPath = 'Emails' . DS . $type;

			$render = $View->render($template, $layout);
			$render = str_replace(array("\r\n", "\r"), "\n", $render);
			$rendered[$type] = $this->_encodeString($render, $this->charset);
		}

		foreach ($rendered as $type => $content) {
			$rendered[$type] = $this->_wrap($content);
			$rendered[$type] = implode("\n", $rendered[$type]);
			$rendered[$type] = rtrim($rendered[$type], "\n");
		}
		return $rendered;
	}
}
