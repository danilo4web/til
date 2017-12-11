<?php 

function tirarAcentos($string){
	return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}

# spotify token
function getSpotifyToken($code) {
	
	# production
	# $SPOTIFY_ID = '807eff3907104f719b13228b4341bea5';
	# $SPOTIFY_SECRET = 'c7e00e73904f4966a0598b9eee81dd01';
	# $SPOTIFY_REDIRECT = 'http://spotify.cervejacrystal.com.br/motive';
	
	$SPOTIFY_ID = '82c9d94b457947629858d5d64714d62c';
	$SPOTIFY_SECRET = '5d3f79e035bc4ae9a2bdba08b0cddd40';
	$SPOTIFY_REDIRECT = 'http://develop.portalacao.com/crystal_spotify/index.php?login_spotify=1#home-playlist';
	
	// get token from spotify
	$auth = base64_encode($SPOTIFY_ID . ":" . $SPOTIFY_SECRET);
	
	$curl = curl_init();
	
	$url = "https://accounts.spotify.com/api/token";
	$data = "grant_type=authorization_code&code=".$code."&redirect_uri=".$SPOTIFY_REDIRECT;
	$headers = array("Authorization: Basic " . $auth);
	
	curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $url,
			CURLOPT_POST => 2,
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_VERBOSE => 0
	));
	
	$resp = curl_exec($curl);
	
	if (curl_errno($curl)) {
		print curl_error($curl); exit;
	}
	
	curl_close($curl);
	
	$resp = json_decode($resp);
	
	$refresh_token = $resp->refresh_token;
	$token = $resp->access_token;
	$expires_in = $resp->expires_in;
	
	return array($token, $refresh_token, $expires_in);
}

function getClientSpotifyToken() {
	
	# production
	# $SPOTIFY_ID = '807eff3907104f719b13228b4341bea5';
	# $SPOTIFY_SECRET = 'c7e00e73904f4966a0598b9eee81dd01';
	# $SPOTIFY_REDIRECT = 'http://spotify.cervejacrystal.com.br/motive';
	
	$SPOTIFY_ID = '82c9d94b457947629858d5d64714d62c';
	$SPOTIFY_SECRET = '5d3f79e035bc4ae9a2bdba08b0cddd40';
	$SPOTIFY_REDIRECT = 'http://demo.portalacao.com/crystal/v_spotify/spotify/retorno.php';
	
	
	// get token from spotify
	$auth = base64_encode($SPOTIFY_ID. ":" . $SPOTIFY_SECRET);
	
	$curl = curl_init();
	$url = "https://accounts.spotify.com/api/token";
	$data = "grant_type=client_credentials";
	$headers = array("Authorization: Basic " . $auth);
	curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $url,
			CURLOPT_POST => 2,
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => $headers
	));
	
	$resp = curl_exec($curl);
	curl_close($curl);
	$resp = json_decode($resp);
	
	$token = $resp->access_token;
	$expires_in = $resp->expires_in;
	
	return array($token, $expires_in);
}

function getMeFromSpotify($token) {
	
	// get user data from spotify
	$curl = curl_init();
	$url = "https://api.spotify.com/v1/me";
	$headers = array("Authorization: Bearer " . $token );
	
	curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $url,
			CURLOPT_HTTPHEADER => $headers
	));
	
	$me = curl_exec($curl);
	curl_close($curl);
	$me = json_decode($me);
	
	return $me;
}

function getTracksBySeed($genres, $artists, $limit, $token) {
	
	// cria uma playlist e retora os dados
	$curl = curl_init();
	$url = "https://api.spotify.com/v1/recommendations?";
	$data = "market=BR";
	
	if (count($genres)) {
		$genres = implode(",", $genres);
		$data .= "&seed_genres=" . $genres;
	}
	
	if (count($artists)) {
		$artists = implode(",", $artists);
		$data .= "&seed_artists=" . $artists;
	}
	
	$data .= "&limit=" . $limit;
	$headers = array("Authorization: Bearer " . $token, 'Content-Type: application/json');
	
	curl_setopt_array($curl, array(
			CURLOPT_URL => $url . $data,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => $headers
	));
	
	$tracks = curl_exec($curl);
	
	if (curl_errno($curl)) {
		print curl_error($curl); exit;
	}
	
	curl_close($curl);
	
	$tracks = json_decode($tracks);
	
	if (!isset($tracks->tracks))
		$tracks->tracks = array();
		
		return $tracks->tracks;
}

function createPlaylist($user_id, $name, $token) {
	
	// cria uma playlist e retora os dados
	$curl = curl_init();
	$url = "https://api.spotify.com/v1/users/" . $user_id . "/playlists";
	$data = new stdClass();
	$data->name = $name;
	$data = json_encode($data);
	
	$headers = array("Authorization: Bearer " . $token, 'Content-Type: application/json');
	curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => $headers
	));
	
	$playlist = curl_exec($curl);
	curl_close($curl);
	$playlist = json_decode($playlist);
	
	return $playlist;
}

function addTracksToPlaylist($user_id, $playlist_id, $ids, $token) {
	
	// inclui músicas na playlist
	$curl = curl_init();
	$url = "https://api.spotify.com/v1/users/".$user_id."/playlists/".$playlist_id."/tracks";
	$data = new stdClass();
	$data->uris = array();
	
	foreach ($ids as $id) {
		$data->uris[] = "spotify:track:" . $id;
	}
	$data = json_encode($data);
	$headers = array("Authorization: Bearer " . $token);
	curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => $headers
	));
	
	$playlist = curl_exec($curl);
	curl_close($curl);
	$playlist = json_decode($playlist);
	
	return $playlist;
}

?>