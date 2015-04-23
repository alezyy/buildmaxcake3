<?php

App::uses('Component', 'Controller');

/**
 * Description of LanguageSuffixeBehavior
 *
 * @author Pec
 */
class LanguageSuffixComponent extends Component {

	/**
	 * Will iterate a flat array to replace all the language suffixes.
	 * 
	 * @param type		$array			Array to be altererated <b>(flat array)<b>
	 * @param type		$newSuffix		String that will replace the old suffix
	 * @param type		$from			exact string to look for<br>
	 *									defaults to NULL which means to only use $suffixSize to match the string
	 * @param int		$suffixSize		Quantity of char in suffix<br>
	 *									Is not use if $from is not NULL
	 * @return array					The array with the altered key name
	 */
	public function switchArrayValues($array, $newSuffix, $from = NULL, $suffixSize = 2) {
		
		$suffix = ($from === NULL)? "(_.{".$suffixSize."})": "(_$from)";
		
		// pattern to use in preg_replace
		$pattern = "/";			
		$pattern .= "(.{1,})";	// regex: capture everything before suffix
		$pattern .= $suffix;	// regex: match the suffix at end of line
		$pattern .= "\z";		// regex: make sure the this is suffix (is at end of line)
		$pattern .= "/";
		
		$replacement = "$1_$newSuffix";	// replacement to use in preg_replace

		foreach ($array as &$value) {
			$value = preg_replace($pattern, $replacement, $value);
		}
		
		return $array;
	}
}

?>
