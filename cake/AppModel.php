<?php
<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	/**
	 * Ao inves de deletar da base de dados, ele preenche o campo data_excluido
	 * (Nao eh exibido no sistema, registros com data_excluido preenchido)
	 *
	 * {@inheritDoc}
	 * @see Model::delete()
	 */
	public function delete($id = null, $cascade = true) {
		$this->id = !empty($id) ? $id : $this->id;
		
		$dados = $this->read(null, $this->id);
		
		// se campo data_excluido existe: PREENCHE e NAO EXCLUI,
		// se nao existe: EXCLUI
		if(isset($dados[$this->alias]) && array_key_exists('data_excluido', $dados[$this->alias])) {
			$dados[$this->alias]['data_excluido'] = date('Y-m-d H:m:s');
			
			if(!$this->save($dados)) {
				
				pr($this->validationErrors);
				exit;
				
			}
		} else {
			if (!$this->getDataSource()->delete($this, array($this->alias . '.' . $this->primaryKey => $this->id))) {
				return false;
			}
		}
		
		// limpa cache
		$this->_clearCache();
		
		return true;
	}
	
	
	/**
	 * converte moeda para guardar no banco
	 *
	 * @param string $data
	 * @return string
	 */
	public static function money($value) {
		return !empty($value) ? str_replace(array('.', ','), array('', '.'), $value) : NULL;
	}
	
	/**
	 * mostra valor formatado para exibicao
	 *
	 * @param string $data
	 * @return string
	 */
	public static function exibeMoney($value, $mostra_simbolo = 1) {
		return (!empty($value) && $value != 0) ? (($mostra_simbolo ? 'R$ ' : '') . number_format($value, 2, ',', '.')) : '-';
	}
	
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
	
}
