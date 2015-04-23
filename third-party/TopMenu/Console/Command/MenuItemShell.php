<?php

class MenuItemShell extends AppShell {

	public $uses = array('MenuItem', 'MenuCategory');

	public function initialize() {
		Configure::write('debug', 2);
		parent::initialize();
	}

	public function main() {

		$dir = new DirectoryIterator("../../Uploads/images");
		foreach ($dir as $fileinfo) {
			if (!$fileinfo->isDot()) {

				// build nice looking name
				// Rename file //TODO change copy to rename
				$newFileName = preg_replace('/5332e69d-95a0-49fb-b224-7096c0a80232(.*)/', 'test$1', $fileinfo->getFilename());
				copy($fileinfo->getPath() . '/' . $fileinfo->getFilename(), $fileinfo->getPath() . '/' . $newFileName);
			}
		}
	}

	private function _buildNiceLookingName($filename) {
		$uuid = preg_replace('/([\da-z\-]{36}).*/', '$1', $filename);

		$mi = $this->MenuItem->findByImage($uuid);
		debug($mi);
	}

}
