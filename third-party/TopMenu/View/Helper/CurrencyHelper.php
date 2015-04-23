<?php
App::uses('AppHelper', 'View/Helper');
/*
 * Date Helper
 *
 */
class CurrencyHelper extends AppHelper {
	public $c_sym = '$';
	public function currency($amount, $type = null) {
		$return = $this->c_sym;
		$amount = number_format((float) $amount, 2, '.', '');

		if ($type === null) {
			if ($amount >= 0) {
				$return .= $amount;
			} else {
				$return .= abs($amount);
				$return = $this->brackets($return);
			}
		} else if ($type == 'receivable') {
			$return .= $amount;
		} else {
			$return .= $amount;
			$return = $this->brackets($return);
		}

		return $return;
	}

	public function brackets($original) {
		return '(' . $original . ')';
	}
}