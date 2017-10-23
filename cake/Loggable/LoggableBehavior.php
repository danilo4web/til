<?php
App::uses('AppModel', 'Model');
class LoggableBehavior extends ModelBehavior 
{
	var $foreing_key; 
	
	
	/**
	 *
	 * {@inheritDoc}
	 * @see ModelBehavior::beforeFind()
	 */
	function beforeFind(Model $model, $query) {
		
		/**
		$Model_MysqlInfo_tables = ClassRegistry::init('MysqlInfo_tables');
		
		if(!$Model_MysqlInfo_tables->find('all', array('conditions' => array('TABLE_SCHEMA' => $model->schemaName, 'TABLE_NAME' => $model->useTable . '_log')))) {
			$this->__criaTabelaNoBanco($model);
		}
		**/
		
		return true;
	}
	
	/**
	 * Verifica se existe a tabela de log criada, se nao tem, ele cria uma copia da tabela
	 * 
	 * {@inheritDoc}
	 * @see ModelBehavior::beforeSave()
	 */
	function beforeSave(Model $model, $options = array()) { 
		
		$Model_MysqlInfo_tables = ClassRegistry::init('MysqlInfo_tables');
		
		if(!$Model_MysqlInfo_tables->find('all', array('conditions' => array('TABLE_SCHEMA' => $model->schemaName, 'TABLE_NAME' => $model->useTable . '_log')))) {
			$this->__criaTabelaNoBanco($model);
		}
		
		return true;
		
	}
	
	/**
	 * Apos execusao de acao (update ou insert) nas MODELS setadas para utilizacao do LogableBehavior:
	 * Grava Log (historico de alteracao)
	 *
	 * {@inheritDoc}
	 * @see ModelBehavior::afterSave()
	 */
	function afterSave(Model $model, $created, $options = array()) {
		
		$logData = array();
		foreach($model->schema() as $campo => $property) {
			$logData[$model->alias . 'Log'][$campo] = isset($model->data[$model->alias][$campo]) ? $model->data[$model->alias][$campo] : $model->field($campo);
		}
		
		// insere codigo usuario responsavel pela acao
		$logData[$model->alias . 'Log']['fk_user'] = $_SESSION['Auth']['Usuario']['id'];
		
		// grava log
		$this->_saveLog($model, $logData);
		
		return true;
	}
	
	function beforeDelete(Model $model, $cascade = true) {
		// exit('antes de deletar');
	}
	
	function afterDelete(Model $model) {
		// exit('apos deletar');
	}
	
	/**
	 * Cria Tabela Log, com base na tabela da model de referencia!
	 * 
	 * @param Object $model
	 */
	private function __criaTabelaNoBanco($model) {
		$Model_MysqlInfo_columns = ClassRegistry::init('MysqlInfo_columns');
		
		$options['fields'] = array('COLUMN_NAME', 'IS_NULLABLE', 'COLUMN_TYPE', 'EXTRA');
		$options['conditions'] = array('TABLE_SCHEMA' => $model->schemaName, 'TABLE_NAME' => $model->useTable);
		
		// retorna campos p/ array incluir nos logs
		$fields = $Model_MysqlInfo_columns->find('all', $options);
		
		// cria tabela log
		$Model_MysqlInfo_columns->query( $this->__geraSQL($model, $fields) );
		
		// limpa cache
		$this->__limpaCache();
	}
	
	/**
	 * Limpa Cache
	 */
	private function __limpaCache() {
		
		$dataSource = ConnectionManager::getDataSource('default');
		
		// chave para delete
		$key = ConnectionManager::getSourceName($dataSource).'_'.$dataSource->config['database'].'_list';
		
		// clear cache
		Cache::delete($key, '_cake_model_');
		Cache::clear(false, '_cake_model_');
	}
	
	/**
	 * Recebe objeto da Model, e campos da tabela principal e cria sql (create table)
	 * 
	 * @param object $model
	 * @param array $fields
	 * 
	 * @return (string)
	 */
	private function __geraSQL($model, $fields) {
		$sql = "CREATE TABLE `" . $model->schemaName. "`.`" . $model->useTable . "_log` (";
		$sql .= "`id` int(11) NOT NULL AUTO_INCREMENT";
		foreach($fields as $k => $field) {
			
			if($field['MysqlInfo_columns']['COLUMN_NAME'] == 'id') {
				$field['MysqlInfo_columns']['COLUMN_NAME'] = $field['MysqlInfo_columns']['COLUMN_NAME'] . "_" . $model->useTable;
			}
			
			$sql .= ", `" . $field['MysqlInfo_columns']['COLUMN_NAME'] . "` " . $field['MysqlInfo_columns']['COLUMN_TYPE'] . " " . ($field['MysqlInfo_columns']['IS_NULLABLE'] == 'YES' ? 'NULL' : 'NOT NULL') . " ";
			
			if($field['MysqlInfo_columns']['COLUMN_TYPE'] == 'timestamp') {
				$sql .= 'DEFAULT 0';
			}
		}
		
		$sql .= ", `fk_user` INT(11) NOT NULL ";
		$sql .= ", `data_ocorrencia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ";
		$sql .= ", PRIMARY KEY (`id`) ) ENGINE=MyISAM CHARSET=utf8;";
		
		return $sql;
	}
	
    /**
     * Grava Log
     * 
     * @param Object $model
     * @param array $logData
     */
    function _saveLog($model, $logData) {
    	
    	// retorna query inclusao de campos (faz verificacao para que nao falte campos na tabela de log)
    	$sql = $this->__comparaTabelaLOG_RetornaSQL($model, $logData);
    	
    	$Tabela = ClassRegistry::init($model->alias);
    	
    	
    	// verifica se existe campo "id", caso exista troca o nome para nao conflitar com a chave primaria da tabela!
    	if(isset($logData[$Tabela->alias . 'Log']['id'])) {
    		$logData[$Tabela->alias . 'Log']["id_{$model->useTable}"] = $logData[$Tabela->alias . 'Log']['id'];
    		unset($logData[$Tabela->alias . 'Log']['id']);
    	}
    	
    	$sql .= ' INSERT INTO ' . $Tabela->useTable . '_log';
    	$sql .= ' (' . implode(', ', array_keys($logData[$Tabela->alias . 'Log'])) . ') VALUES';
    	$sql .= " ('" . implode("', '", array_values($logData[$Tabela->alias . 'Log'])) . "');";
    	
    	$Tabela->query($sql);
    }
    
    /**
     * Compara Tabela que esta sendo alterada com tabela de LOG
     * (se nao existir os campos necessarios na tabela de log, ele cria e sincroniza com a tabela referencia)
     * 
     * @param object $model
     * @param array $logData
     * @return (string)
     */
    public function __comparaTabelaLOG_RetornaSQL($model, $logData) {
    	
    	$campos_tabela = $this->__retornaCampos($model->schemaName, $model->useTable);
    	$campos_tabela_log = $this->__retornaCampos($model->schemaName, $model->useTable . '_log');
    	
    	$sql = "";
    	foreach($campos_tabela as $campo => $valor) {
    		if(!array_key_exists($campo, $campos_tabela_log)) {
    			$sql .= "ALTER TABLE " . $model->useTable . "_log ADD COLUMN " . $campo . " " . $valor . " NULL; ";
    		}
    	}
    	
    	return $sql;
    }
    
    /**
     * Retorna campos da estrutura de uma determinada tabela
     * 
     * @param string $schema
     * @param string $tabela
     * @return (array)
     */
    public function __retornaCampos($schema, $tabela) {
    	$Model_MysqlInfo_columns = ClassRegistry::init('MysqlInfo_columns');
    	
    	$options['fields'] = array('COLUMN_NAME', 'COLUMN_TYPE');
    	$options['conditions'] = array('TABLE_SCHEMA' => $schema, 'TABLE_NAME' => $tabela);
    	
    	return $Model_MysqlInfo_columns->find('list', $options);
    }
}
?>