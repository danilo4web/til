<?php 
	function summarize($text, $quantity, $simbol = '...') {
		return str_reduce($text, $quantity) . ((strlen($text) > $quantity) ? " {$simbol}" : '');
	}
?>