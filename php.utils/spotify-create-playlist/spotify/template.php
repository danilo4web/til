
	<?php if(!isset($_SESSION['login_spotify']) || (isset($_SESSION['login_spotify']) && $_SESSION['login_spotify'] == 0)) : ?>
		<div class="centered">
			<form action="spotify/login.php" method="GET">
	            <h2>A CRYSTAL VAI CRIAR UMA PLAYLIST<br>PERSONALIZADA PARA TORNAR SEU<br>ENCONTRO <strong>UMA VERDADEIRA FESTA.</strong></h2>
	            <button class="large button" name="login" value="spotify">CONECTAR COM SPOTIFY</button>
	            <button class="large button" name="login" value="anonymous">CONECTAR SEM SPOTIFY</button>
			</form>		
		</div>
	<?php else : ?>
	
		<?php if(isset($_SESSION['playlist']) && $_SESSION['playlist']) : ?>
			<div class="five columns animated fadeIn delay-2 mobileonly centered">
				<h2><strong>SUA PLAYLIST TÁ NA MÃO!</strong></h2>
				<p>Aproveite o som, os amigos e seu encontro com Crystal. Compartilhe em suas redes sociais.</p>
			</div>
			
	        <div class="centered">
	        	<div class="playlist">
	        	
	            	<?php if(isset($_SESSION['playlist']) && $_SESSION['playlist']) : ?>
	            		<iframe src="https://embed.spotify.com/?uri=spotify:user:<?php echo $_SESSION['spotify_user']->id; ?>:playlist:<?php echo $_SESSION['playlist']; ?>" width="300" height="400" frameborder="0" allowtransparency="true"></iframe>
	            	<?php else : ?>
		              	<iframe src="https://embed.spotify.com/?uri=spotify:trackset:<?php echo $_SESSION['playlist']; ?>:<?php echo $_SESSION['tracks']; ?>" frameborder="0" allowtransparency="true" width="300" height="400"></iframe>
		            <?php endif; ?>
		            
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
						<input type="hidden" name="spotify_logout" value="1" />
                		<button>REFAZER MINHA PLAYLIST!</button>
              		</form>		            
	          	</div>
	        </div>
		
		<?php else : ?>
			<div class="row" id="escolha-tema">
				<div class="centered">
		          <h2>E AÍ, QUAL É O ENCONTRO COM A GALERA?</h2>
		        </div>
			    <div>
			        <div class="motive">
			          <div id="motive-0" class="tampinha centered active" data-motive="Churrasco">
			            <div class="icon"><img alt="" src="img/spotify/motive/churrasco.png"></div>
			            <div class="title">Churrasco</div>
			          </div>
			        </div>
			        <div class="motive">
			          <div id="motive-1" class="tampinha centered" data-motive="Cervejada">
			            <div class="icon"><img alt="" src="img/spotify/motive/cervejada.png"></div>
			            <div class="title">Cervejada</div>
			          </div>
			        </div><div class="motive">
			          <div id="motive-2" class="tampinha centered" data-motive="Galera das antigas">
			            <div class="icon"><img alt="" src="img/spotify/motive/galera.png"></div>
			            <div class="title">Galera das antigas</div>
			          </div>
			        </div><div class="motive">
			          <div id="motive-3" class="tampinha centered" data-motive="Feriadão TOP">
			            <div class="icon"><img alt="" src="img/spotify/motive/feriado.png"></div>
			            <div class="title">Feriadão TOP</div>
			          </div>
			        </div><div class="motive">
			          <div id="motive-4" class="tampinha centered" data-motive="Domingão em família">
			            <div class="icon"><img alt="" src="img/spotify/motive/domingo.png"></div>
			            <div class="title">Domingão em família</div>
			          </div>
			        </div><div class="motive">
			          <div id="motive-5" class="tampinha centered" data-motive="Futebol">
			            <div class="icon"><img alt="" src="img/spotify/motive/futebol.png"></div>
			            <div class="title">Futebol</div>
			          </div>
			        </div><div class="motive">
			          <div id="motive-6" class="tampinha centered" data-motive="Happy Hour">
			            <div class="icon"><img alt="" src="img/spotify/motive/happyhour.png"></div>
			            <div class="title">Happy Hour</div>
			          </div>
			        </div><div class="motive">
			          <div id="motive-7" class="tampinha centered esquenta" data-motive="Esquenta">
			            <div class="icon"><img alt="" src="img/spotify/motive/esquenta.png"></div>
			            <div class="title">Esquenta</div>
			          </div>
			        </div>
			    </div>
						    
				<div class="row">
			        <div class="centered">
			          <h3>Não achou seu encontro aí em cima?</h3>
			        </div>
			        <div class="centered">
			        	<label>Motivo:</label>
			          	<input type="text" name="name_motivo" maxlength="40" placeholder="Então digite aqui">
			          
			          <div class="wrap">
			            <button onclick="call_ritmo();">PRÓXIMO</button>
			          </div>
			        </div>
				</div>
		    </div>
		
		
			<div class="row" id="escolha-ritmo" style="display: none;">
				<div class="centered">
		          <h2>QUAIS OS ESTILOS DE MÚSICA QUE A GALERA CURTE?</h2>
		        </div>
		        
			    <div>
					<div class="motive">
						<div id="motive-0" class="tampinha centered " data-genre="Pop">
			            	<div class="icon"><img alt="" src="img/spotify/genre/pop.png"></div><div class="title">Pop</div>
			        </div>
			        </div><div class="motive">
						<div id="motive-1" class="tampinha centered " data-genre="Rock">
							<div class="icon"><img alt="" src="img/spotify/genre/rock.png"></div><div class="title">Rock</div>
			          	</div>
			        </div>
			        <div class="motive">
			        	<div id="motive-2" class="tampinha centered " data-genre="Pagode">
							<div class="icon"><img alt="" src="img/spotify/genre/pagode.png"></div><div class="title">Pagode</div>
			        	</div>
			        </div>
			        <div class="motive">
						<div id="motive-3" class="tampinha centered " data-genre="Sertanejo">
							<div class="icon"><img alt="" src="img/spotify/genre/sertanejo.png"></div><div class="title">Sertanejo</div>
			          	</div>
					</div>
					<div class="motive">
			          	<div id="motive-4" class="tampinha centered " data-genre="Arrocha">
							<div class="icon"><img alt="" src="img/spotify/genre/arrocha.png"></div><div class="title">Arrocha</div>
			          	</div>
			        </div>
			        <div class="motive">
			          	<div id="motive-5" class="tampinha centered " data-genre="Forró">
			            	<div class="icon"><img alt="" src="img/spotify/genre/forro.png"></div><div class="title">Forró</div>
						</div>
					</div>
					<div class="motive">
						<div id="motive-6" class="tampinha centered " data-genre="Reggae">
							<div class="icon"><img alt="" src="img/spotify/genre/reggae.png"></div><div class="title">Reggae</div>
			          	</div>
			        </div>
			        <div class="motive">
						<div id="motive-7" class="tampinha centered samba" data-genre="Samba">
							<div class="icon"><img alt="" src="img/spotify/genre/samba.png"></div><div class="title">Samba</div>
			          	</div>
			        </div>
			    </div>
				<div class="row">
			        <div class="centered">
			        	<label>Motivo:</label>
			          	<input type="text" name="name_motivo" maxlength="40" placeholder="Então digite aqui">
				        <div class="wrap">
				            <button onclick="call_duration();">PRÓXIMO</button>
				        </div>
			        </div>
				</div>		    
			</div>
			
			<div class="row" id="escolha-duracao" style="display: none;">
				<div class="centered">
	          		<h2>A GALERA É PONTA FIRME?<br>QUANTO TEMPO VAI DURAR O ENCONTRO?</h2>
	        	</div>
		      	<div>
			        <div class="duration">
			          <div class="tampinha centered " id="duration-0" data-time="1">
			            <div class="icon"><img alt="" src="img/spotify/hour/3.png"></div><div class="title">1 horas</div>
			          </div>
			        </div><div class="duration">
			          <div class="tampinha centered " id="duration-1" data-time="3">
			            <div class="icon"><img alt="" src="img/spotify/hour/6.png"></div><div class="title">3 horas</div>
			          </div>
			        </div><div class="duration">
			          <div class="tampinha centered " id="duration-2" data-time="5">
			            <div class="icon"><img alt="" src="img/spotify/hour/9.png"></div><div class="title">5 horas</div>
			          </div>
			        </div><div class="duration">
			          <div class="tampinha centered " id="duration-3" data-time="7">
			            <div class="icon"><img alt="" src="img/spotify/hour/12.png"></div><div class="title">7 horas</div>
			          </div>
			        </div>
		      	</div>
		      	
			  	<form id="form_cria_playlist" method="get" action="spotify/cria_playlist.php">
			  	
			  		<input type="hidden" name="motivo" value="" id="input_motivo" />
			  		<input type="hidden" name="ritmo" value="" id="input_ritmo" />
			  		
		        	<div class="centered">
		          		<h3><strong>Precisa de mais tempo?</strong><br>
		          		Quantas horas vai durar esse encontro?</h3>
		        	</div>
		        	<div class="centered">
		          		<div class="typed-time">
		            		<input class="field" type="number" name="duration" min="1" max="12" placeholder="12"> horas
		          		</div>
		          		<div class="wrap">
		            		<button onclick="cria_playlist();">PRÓXIMO</button>
		          		</div>
		        	</div>
		      	</form>
		   	</div>		
		<?php endif; ?>
	<?php endif; ?>