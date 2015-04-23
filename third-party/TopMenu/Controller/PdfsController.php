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

App::uses('AppController', 'Controller');

/**
 * PdfsController
 * Responsible for fetching PDF files and serving them up
 */
class PdfsController extends AppController {


/**
 * beforeFilter
 * @return void
 */
	public function beforeFilter() {
		$this->Auth->allow('get_pdf', 'render_pdf');
		parent::beforeFilter();
	}

/**
 * Gets a PDF from our store
 * Fetch either by UUID, or a restaurants url
 * Return the file to be downloaded named properly
 * @param  string $id UUID, or a url
 * @return void
 */
	public function get_pdf($id) {

		$type = false;

		$this->autoRender = false;

		if ($this->Pdf->validateUUID($id)) {
			// We found a valid UUID, push the file
			$this->_pushFile($id);
		} else {
			$pdf_menu = $this->Pdf->Location->getPdfMenuByUrl($id);
			if ($pdf_menu && !empty($pdf_menu)) {
				// We got an ID, push the file and give it the url as the download name
				$this->_pushFile($pdf_menu['Location']['pdf_menu'], $id);
			} else {
                
                $this->response->statusCode(404);
                $this->set('title_for_layout', __('PDF not found - 404'));
                $this->set('message', __('Sorry we could not find your page'));
                $this->render('/Elements/404');
			}
		}               
	}

/**
 * Pushes a file to the browser
 * @param  uuid   $id            UUID of the PDF
 * @param  string $download_name what we want to call the download
 * @return void
 */
	private function _pushFile($id, $download_name = null) {

		$this->Pdf->id = $id;

		if (!$this->Pdf->exists()) {
			throw new NotFoundException(__('PDF Not Found!'));
		}

		if ($download_name === null) {
			$download_name = $this->Pdf->getDownloadName();
		}

		$this->Pdf->getPDF();

		// Build the headers
		$headers = array(
			'Content-Disposition' => 'inline; filename="' . $download_name . '.pdf"',
			'Content-length'      => $this->Pdf->size
		);

		$this->response->header($headers);

		$this->response->body($this->Pdf->pdf);

		$this->response->type('application/pdf');
	}
}