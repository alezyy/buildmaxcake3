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

App::uses('AppModel', 'Model');
/**
 * UploadedFile Model
 * Serves as a registry for files we store with
 * ImageComponent and PDFMenuComponent
 * This will make keeping our hdd clean if files ever get
 * lost.
 */
class UploadedFile extends AppModel {

/**
 * Add a file to the registry
 * @param string $id    uuid of the file
 * @param string $type  image or pdf
 * @param string $field field name in Model.field notation
 */
	public function addFile($id, $type, $field, $foreign_key = null, $original_extension = null) {
		if ($this->exists($id)) {
			return false;
		}
		$this->create();

		$data = array(
			'id'          => $id,
			'type'        => $type,
			'field'       => $field,
			'foreign_key' => $foreign_key
		);
		if ($original_extension !== null) {
			$data['original_extension'] = $original_extension;
		}
		if ($this->save($data)) {
			return true;
		}
		return false;
 	}

/**
 * Gets the  file extention of the original file  (for images)
 * @param  string $id UUID
 * @return string     or false on failure
 */
 	public function getOriginalExtension($id) {
 		$result = $this->find('first', array(
 			'conditions' => array(
 				'UploadedFile.id' => $id
 			),
 			'fields' => array(
 				'UploadedFile.original_extension'
 			)
 		));
 		if ($result) {
 			return $result['UploadedFile']['original_extension'];
 		}
 		return false;
 	}

/**
 * Sets the foriegn key of an image after creating a new record.
 * We don't need to do this when updating a record...
 * @param string $id          UUID of the file
 * @param string $foreign_key UUID of the foreign record
 */
 	public function setForeignKey($id, $foreign_key) {
 		$this->id = $id;
 		if (!$this->exists()) {
			return false;
		}
		if ($this->saveField('foreign_key', $foreign_key)) {
			return true;
		}
		return false;
 	}

/**
 * Delete a file from the registry
 * @param  string $id UUID of the file
 * @return bool     true on success, false on failure
 */
 	public function deleteFile($id) {
 		$this->id = $id;
 		if ($this->exists()) {
 			if ($this->delete()) {
 				return true;
 			}
 		}
 		return false;
 	}

}