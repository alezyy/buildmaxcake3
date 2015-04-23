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
App::import('Vendor','tcpdf/tcpdf');

/**
 * PdfComponent
 * Abstraction layer for TCPDF library
 */
class PdfComponent extends Component {

/**
 * Intance of TCPDF object
 */
	private $tcpdf = false;

/**
 * Returns the PDF as a string, and destroys
 * the object.
 * @return string PDF
 */
	public function output() {
		$output = $this->tcpdf->Output(null, 'S');
		unset($this->tcpdf);
		$this->tcpdf = false;
		return $output;
	}

/**
 * Creates a document and will figure out the orientation
 * based on the height and width provided, unless otherwise
 * specified.
 * @param  int    $height      Height of the canvas
 * @param  int    $width       Width of the canvas
 * @param  char   $orientation (P: portrate | L: landscape)
 * @return PdfComponent        Returns an instance of this object
 */
	public function create($height, $width, $orientation = null) {
		if ($orientation === null) {
			$orientation = ($height > $width) ? 'P' : 'L';
		} else {
			$orientation = (strtoupper($orientation) == 'P') ? 'P' : 'L';
		}

		$this->tcpdf = $tcpdf = new TCPDF($orientation, 'pt', array($width, $height), true, 'UTF-8', false);
		return $this;
	}

/**
 * Adds a page to the document
 * @return   Instance of this object
 */
	public function addPage() {
		// add a page (required with recent versions of tcpdf)
		$this->tcpdf->AddPage();
		return $this;
	}

/**
 * Sets the jpeg render quality
 * @param integer $quality 1-100
 * @return   Instance of this object
 */
	public function setJPEGQuality($quality = 100) {
		$this->tcpdf->setJPEGQuality($quality);
		return $this;
	}

/**
 * Add an image to the document
 * @param  string $image Raw image string
 * @return   Instance of this object
 */
	public function image($image) {
		$this->tcpdf->Image('@' . $image);
		return $this;
	}

/**
 * Returns the TCPDF object in case we feel like
 * directly interacting with it.
 * @return object TCPDF
 */
	public function getInsance() {
		return $this->tcpdf;
	}
}