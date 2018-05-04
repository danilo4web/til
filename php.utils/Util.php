<?php
class Util {
	
	/**
	 * converte data d/m/Y para Y-m-d
	 *
	 * @param string $data
	 * @return string
	 */
	public function dateToDb($data) {
		return !empty($data) ? implode("-", array_reverse(explode("/", $data))) : NULL;
	}
	
	/**
	 * converte data Y-m-d para d/m/Y (ou d/m/Y H:i:s)
	 *
	 * @param string $data
	 * @return string
	 */
	public function dbToDate($data, $with_hours = 0) {
		
		if($with_hours) {
			$hour = substr($data, 11, 8);
			$data = substr($data, 0, 10);
		}
		
		return (!empty($data) ? implode("/", array_reverse(explode("-", $data))) : '') . (isset($hour) ? ' ' . $hour : '');
	}
	
	/**
	 * converte string para camelCase
	 * @param string $str
	 * @param boolean $first_UPPERCASE
	 * @return string
	 */
	public function convertCamelCase($str, $first_UPPERCASE = false) {
		if($first_UPPERCASE) {
			$str[0] = strtoupper($str[0]);
		}
		
		return preg_replace_callback('/_([a-z])/', create_function('$c', 'return strtoupper($c[1]);'), $str);
	}
	
	/**
	 * converte CamelCase para string_without_camel_case
	 * @param string $str
	 * @return string
	 */
	public function fromCamelCase($str) {
		$str[0] = strtolower($str[0]);
		$func = create_function('$c', 'return "_" . strtolower($c[1]);');
		return preg_replace_callback('/([A-Z])/', $func, $str);
	}
	
	/**
	 * retira acentuacao
	 * @param string $str
	 * @return string
	 */
	public function tirarAcentos($str){
		return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $str);
	}
	
	
	
}