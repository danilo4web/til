<?php
App::uses('AppModel', 'Model');

class Importar extends AppModel {
	
	public $useDbConfig = 'cb';
	public $name = "Importar";
	public $useTable = "importar";
	public $primaryKey = "id";
	
	public function converteFiltrosEmConditions($data, $conditions = array()) {
		
		if(isset($data[$this->name]['periodo_de_veiculacao']) && $data[$this->name]['periodo_de_veiculacao']) {
			$conditions[] = $this->name.".periodo_de_veiculacao = '{$data[$this->name]['periodo_de_veiculacao']}'";
		}
		
		if(isset($data[$this->name]['nome_planilha']) && $data[$this->name]['nome_planilha']) {
			$conditions[] = $this->name.".nome_planilha = '{$data[$this->name]['nome_planilha']}'";
		}
		
		if(isset($data[$this->name]['type']) && $data[$this->name]['type']) {
			$conditions[] = $this->name.".tipo_planilha = '{$data[$this->name]['type']}'";
		}
		
		if((isset($data[$this->name]['data_importacao_ini']) && $data[$this->name]['data_importacao_ini'])) {
			$conditions[] = $this->name.".data_importacao >= '".implode('-', array_reverse(explode('/', $data[$this->name]['data_importacao_ini'])))."'";
		}
		
		if((isset($data[$this->name]['data_importacao_fim']) && $data[$this->name]['data_importacao_fim'])) {
			$conditions[] = $this->name.".data_importacao <= '".implode('-', array_reverse(explode('/', $data[$this->name]['data_importacao_fim'])))."'";
		}
		
		return $conditions;
	}
	
}