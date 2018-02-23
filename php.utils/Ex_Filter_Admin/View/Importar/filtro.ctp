				
				<div class="well">
					<?php echo $this->Form->create('Importar', array('onsubmit' => false)); ?>
						<div class="col-sm-2" style="max-width: 170px; min-width: 170px;">
							<label> Periodo de Veiculação </label>
							<?php echo $this->Form->input('periodo_de_veiculacao', array('label' => false, 'class' => 'form-control input-md', 'options' => $lista_periodo_de_veiculacao, 'empty' => 'Todos', 'style' => 'width: 100%;')); ?>
						</div>
						
						<div class="col-sm-2" style="max-width: 170px; min-width: 170px;">
							<label> Tipo da Planilha </label>
							<?php echo $this->Form->input('type', array('label' => false, 'class' => 'form-control input-md', 'options' => $lista_tipos_planilha, 'empty' => 'Todos', 'style' => 'width: 100%;')); ?>
						</div>						
						
						<div class="col-sm-2" style="max-width: 170px; min-width: 170px;">
							<label> Nome da Planilha </label>
							<?php echo $this->Form->input('nome_planilha', array('label' => false, 'class' => 'form-control input-md', 'options' => $lista_nome_planilha, 'empty' => 'Todos', 'style' => 'width: 100%;')); ?>
						</div>						
						
						<div class="col-sm-2" style="min-width: 185px;">
							<label> Data Importação </label>
							<?php echo $this->Form->input('data_importacao_ini', array('type' => 'text', 'label' => false, 'class' => 'form-control input-md datepicker', 'style' => 'float: left; width: 42%; min-width: 70px; font-size: 12px;')); ?> <span style="width: 3px; float: left; padding-top: 5px; margin: 4px;">à</span> 
							<?php echo $this->Form->input('data_importacao_fim', array('type' => 'text', 'label' => false, 'class' => 'form-control input-md datepicker', 'style' => 'margin-left: 3px; float: left; width: 42%; min-width: 70px; font-size: 12px;')); ?>
						</div>
						
        				<div class="right" style="margin: 25px 5px 0 0;">
        					<a href="javascript:void(0);" id="limpar_busca" class="btn btn-info"><i class="fa fa-eraser"></i> Limpar</a>
        					<a href="javascript:void(0);" id="busca_importar" class="btn btn-warning"><i class="fa fa-search"></i> Buscar</a>
        				</div>
				        <div class="clear"></div>
				    <?php echo $this->Form->end(); ?>
				</div>
				<hr class="clear hr" />
				
				<?php echo $this->Html->scriptBlock('
					jQuery(".datepicker").datepicker({
	   					format: "dd-mm-yyyy",
	   					dayNames: ["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"],
						dayNamesMin: ["D","S","T","Q","Q","S","S","D"],
						dayNamesShort: ["Dom","Seg","Ter","Qua","Qui","Sex","Sáb","Dom"],
						monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
						monthNamesShort: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
						nextText: "Próximo",
						prevText: "Anterior"
    				});  
				'); ?>
