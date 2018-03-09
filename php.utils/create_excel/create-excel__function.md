<?php

	App::uses('PHPExcel', 'Vendor');
	
	public function gera_xls() {
		
		$excel = new PHPExcel();
		
		// Cabecalho
		$excel->setActiveSheetIndex(0)
		->setCellValue('A1', "Agência Solicitante")
		->setCellValue('B1', "Nome do Solicitante")
		->setCellValue("C1", "Anuente")
		->setCellValue("D1", "Cliente")
		->setCellValue("E1", "Job/Projeto")
		->setCellValue("F1", "Físico ou Digital?")
		->setCellValue("G1", "Data da Solicitação")
		->setCellValue("H1", "Data de Envio da Primeira Resposta")
		->setCellValue("I1", "Data da Última Resposta")
		->setCellValue("J1", "Data de Liberação para Assinaturas")
		->setCellValue("K1", "Data de Recebimento da Via Assinada")
		->setCellValue("L1", "Tipo (objeto)")
		->setCellValue("M1", "Valor")
		->setCellValue("N1", "Minuta Interna ou Externa?")
		->setCellValue("O1", "Escritório Minuta Externa")
		->setCellValue("P1", "Data de Assinatura")
		->setCellValue("Q1", "Prazo do Contrato")
		->setCellValue("R1", "Plataformas de Veiculação (mídia)")
		->setCellValue("S1", "Quem arca com o custo? (Agência, cliente ou jurídico)");
		
		$lista_pagadores = $this->Pagador->find('list', array('fields' => array('codigo', 'descricao')));
		$conditions = $this->Contrato->converteFiltrosEmConditions($this->Session->read('Contrato'));
		$conditions[] = 'Contrato.fk_tipo_controle = 2';  // mostrar somente contratos
		$lista = $this->Contrato->lista($conditions);
		
		foreach($lista as $key => $registro) {
			$indice = $key + 2;
			
			$array_pagadores = array();
			$pagadores = $this->ContratoPagador->find('list', array('conditions' => array('fk_contrato' => $registro['Contrato']['codigo']), 'fields' => array('codigo', 'fk_pagador')));
			foreach($pagadores as $k => $item) {
				$array_pagadores[] = $lista_pagadores[$item];
			}
			
			$excel->getActiveSheet()
			->setCellValueByColumnAndRow(0, $indice, $registro['Agencia']['descricao'])
			->setCellValueByColumnAndRow(1, $indice, $registro['Contrato']['nome_solicitante'])
			->setCellValueByColumnAndRow(2, $indice, $registro['Contrato']['anuente'])
			->setCellValueByColumnAndRow(3, $indice, $registro['Cliente']['nome'])
			->setCellValueByColumnAndRow(4, $indice, $registro['Projeto']['descricao'])
			->setCellValueByColumnAndRow(5, $indice, ($registro['Contrato']['fisico'] == '1') ? 'físico' : 'digital')
			->setCellValueByColumnAndRow(6, $indice, AppModel::dbToDate($registro['Contrato']['data_solicitacao']))
			->setCellValueByColumnAndRow(7, $indice, AppModel::dbToDate($registro['Contrato']['data_primeira_resposta']))
			->setCellValueByColumnAndRow(8, $indice, AppModel::dbToDate($registro['Contrato']['data_ultima_resposta']))
			->setCellValueByColumnAndRow(9, $indice, AppModel::dbToDate($registro['Contrato']['data_liberacao_assinatura']))
			->setCellValueByColumnAndRow(10, $indice, AppModel::dbToDate($registro['Contrato']['data_recebimento_via_assinada']))
			->setCellValueByColumnAndRow(11, $indice, $registro['Contrato']['tipo_objeto'])
			->setCellValueByColumnAndRow(12, $indice, AppModel::exibeMoney($registro['Contrato']['valor']))
			->setCellValueByColumnAndRow(13, $indice, ($registro['Contrato']['minuta_interna'] == '1') ? 'interna' : 'externa')
			->setCellValueByColumnAndRow(14, $indice, $registro['Escritorio']['descricao'])
			->setCellValueByColumnAndRow(15, $indice, AppModel::dbToDate($registro['Contrato']['data_assinatura']))
			->setCellValueByColumnAndRow(16, $indice, $registro['Contrato']['prazo_contrato'])
			->setCellValueByColumnAndRow(17, $indice, $registro['TipoPlataforma']['descricao'])
			->setCellValueByColumnAndRow(18, $indice, implode("/", $array_pagadores));
		}
		
		// Titulo Planilha
		$excel->getActiveSheet()->setTitle('Controle de Contratos');
		
		// Cabeçalho do arquivo
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="controle_contratos_' . date('Y_m_d') . '.xls"');
		header('Cache-Control: max-age=0');
		
		// Se for o IE9, eh necessario
		header('Cache-Control: max-age=1');
		
		// Acessamos o 'Writer' para poder salvar o arquivo
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		
		// Salva diretamente no output
		$objWriter->save('php://output');
		exit;
	}
	
?>