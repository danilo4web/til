<?php 
	function __summarize($text, $quantity, $simbol = '') {
		if(strlen($text) > $quantity) {
			$text = substr($text, 0, strrpos(substr($text, 0, $quantity), ' ')) . ' ' . $simbol;
		}
		
		return $text;
	}
?>