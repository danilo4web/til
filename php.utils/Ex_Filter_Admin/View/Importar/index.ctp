			<div class="box padding20">
            	<div class="col-md-12">
            		<h3 class="table">Nome da Pagina</h3>
            	</div>

	            <div class="col-md-3 right" style="margin-top: 20px;">
					<a href="#" class="btn right"> Novo </a>
				</div>
				<hr class="clear hr" />
				
				<?php echo $this->requestAction('Importar/filtro/', array('return')); ?>
				<div id="listagem" class="overlay-lista"></div>
			</div>
			
			<?php echo $this->Html->script('importar'); ?>