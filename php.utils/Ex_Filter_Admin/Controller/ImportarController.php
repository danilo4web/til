<?php
App::uses('AppController', 'Controller');

class ImportarController extends AppController {
	
	public function index() {
		$title = "Titulo Pagina";
		$this->set(compact('title'));
	}
	
	public function filtro() {
		$this->layout = false;
		$this->data = $this->Session->read('Importar');
		$this->__carregaCombos();
	}
	
	public function listar() {
		$this->layout = false;
		
		if ($this->data) {
			$this->Session->write('Importar', $this->data);
		}
		
		$model_Importar = ClassRegistry::init('Importar');
		$options ['conditions'] = $model_Importar->converteFiltrosEmConditions($this->Session->read('Importar'));
		$lista = $model_Importar->find('all', $options);
		
		$this->__carregaCombos();
		$this->set(compact('lista'));
	}
	
	private function __carregaCombos($codigo = null) {
		$lista_campo = array('1' => 'Planilha Base por Dia', '2' => 'Planilha Connect Mix');
		
		$this->set(compact('lista_campo'));
	}
}
