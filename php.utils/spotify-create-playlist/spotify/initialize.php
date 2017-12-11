<?php 

require_once('spotify/functions.php');

if(isset($_GET['spotify_logout']) && $_GET['spotify_logout'] == '1') {
	
	$logout = file_get_contents("http://open.spotify.com/logout");
	$logout = json_decode($logout);
	
	if($logout->success == "1") {
		
		unset($_SESSION['login_spotify']);
		unset($_SESSION['expires']);
		unset($_SESSION['token']);
		unset($_SESSION['spotify_user']);
		unset($_SESSION['playlist']);
		
		header("Location: {$_SERVER['PHP_SELF']}#home-playlist");
	}
	
}

if (isset($_GET['code']) && (isset($_GET['login_spotify']) && $_GET['login_spotify'] == '1')) {
	
	if(!isset($_SESSION['login_spotify'])) {
		list($token, $refresh_token, $expires_in) = getSpotifyToken($_GET['code']);
		
		if((isset($token) && $token) && (isset($refresh_token) && $refresh_token) && (isset($expires_in) && $expires_in)) {
			
			$_SESSION['token'] = $token;
			$_SESSION['expires'] = time() + $expires_in;
			$_SESSION['login_spotify'] = '1';
			$_SESSION['spotify_user'] = getMeFromSpotify($token);
			
			// expired token
			if ( isset($_SESSION['spotify_user']->error) ) {
				exit('some error occurred');
			}
			
			// check de idade
			if ($_SESSION['spotify_user']->birthdate != "") {
				$idade = explode("-", $_SESSION['spotify_user']->birthdate);
				$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
				$nascimento = mktime( 0, 0, 0, (int) $idade[1], (int) $idade[2], (int) $idade[0]);
				
				if (floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25) < 18) {
					exit('Voce eh menor de 18 anos');
				}
			}
			
			############## SALVAR DADOS NO BANCO
		}
	}
	
	header("Location: {$_SERVER['PHP_SELF']}#home-playlist");
}
?>