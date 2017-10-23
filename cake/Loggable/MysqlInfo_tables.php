<?php
App::uses('AppModel', 'Model');

class MysqlInfo_tables extends AppModel {
	
	public $useDbConfig = 'db_information';
	public $name = "MysqlInfo_tables";
	public $useTable = "TABLES";
	
	#public $primaryKey = "codigo";
	
	public function retorna_tables() {
		return $this->find('all', array('conditions' => array('TABLE_SCHEMA' => 'juridico'), 'fields' => array('TABLE_NAME')));
	}
}
