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

App::uses('Component', 'Controller');
class x509Component extends Component {
	public function hasValidCert() {
		if (
			!isset($_SERVER['SSL_CLIENT_M_SERIAL'])
			|| !isset($_SERVER['SSL_CLIENT_V_END'])
			|| !isset($_SERVER['SSL_CLIENT_VERIFY'])
			|| $_SERVER['SSL_CLIENT_VERIFY'] !== 'SUCCESS'
			|| !isset($_SERVER['SSL_CLIENT_I_DN'])
		) {
			return false;
	    }

	    if ($_SERVER['SSL_CLIENT_V_REMAIN'] <= 0) {
	        return false;
	    }
	    return true;
	}
}