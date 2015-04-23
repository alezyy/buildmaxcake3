<?php
App::uses('AppHelper', 'View/Helper');


class ESHelper extends AppHelper {

	public function getValue($data, $key) {
		if (isset($data[$key])) {
			return $data[$key];
		}

		if(strpos($key, '.')) {
			$key = explode('.', $key);
			$model = $key[0];
			$field = $key[1];

			if (isset($data[$model][$field])) {
				return $data[$model][$field];
			}
		}

		return null;
	}

}