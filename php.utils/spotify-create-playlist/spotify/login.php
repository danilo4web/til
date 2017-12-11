<?php 

	# production
	# $SPOTIFY_ID = '807eff3907104f719b13228b4341bea5';
	# $SPOTIFY_SECRET = 'c7e00e73904f4966a0598b9eee81dd01';
	# $SPOTIFY_REDIRECT = 'http://spotify.cervejacrystal.com.br/motive';
	
	$SPOTIFY_ID = '82c9d94b457947629858d5d64714d62c';
	$SPOTIFY_SECRET = '5d3f79e035bc4ae9a2bdba08b0cddd40';
	$SPOTIFY_REDIRECT = 'http://develop.portalacao.com/crystal_spotify/index.php?login_spotify=1#home-playlist';
	
	$url = 'https://accounts.spotify.com/authorize?';
	$scope = 'user-read-email playlist-modify-public user-read-birthdate';
	
	$data = 'response_type=code&';
	$data .= 'client_id='.urlencode($SPOTIFY_ID).'&';
	$data .= 'redirect_uri='. urlencode($SPOTIFY_REDIRECT) .'&';
	$data .= 'scope='. urlencode($scope) .'&';
	
	header('Location: ' . trim($url) . trim($data));
?>