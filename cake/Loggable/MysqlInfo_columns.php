<?php
App::uses('AppModel', 'Model');

class MysqlInfo_columns extends AppModel {
	
	public $useDbConfig = 'db_information';
	public $name = "MysqlInfo_columns";
	public $useTable = "COLUMNS";
	#public $primaryKey = "codigo";

	public function retorna_colunas_de_uma_table($table) {
		
		if($table) {
			return $this->find('all', array('conditions' => array('TABLE_SCHEMA' => 'juridico', 'TABLE_NAME' => $table), 'fields' => array('TABLE_NAME', 'COLUMN_NAME')));
		} else {
			return array();
		}
	}
}
