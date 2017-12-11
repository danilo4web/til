<?php 
@session_start();
require_once("functions.php");

// pega token do spotify e salva dados
if (isset($_SESSION['login_spotify'])) {
	
	$player = true;
	
	$total = 0;
	$duration = $_REQUEST['duration']; // 6 horas
	
	// $genres = session('genre'); // ["alt-rock","rock"];
	$genres = explode(",", strtolower(tirarAcentos($_REQUEST['ritmo'])));
	
	if (in_array("arrocha", $genres)) {
		$artists = array("1oYhynFI8ZgMAlYbyttb3f");
		unset($genres[array_search("arrocha", $genres)]);
	} else {
		$artists = array();
	}
	
	$tracks = getTracksBySeed($genres, $artists, "50", $_SESSION['token']);
	
	// if (Auth::check()) {
	// 	$logged = true;
	// 	$me = Auth::user();
	// 	$token = session('token');
	
	// } else {
	// 	// anonymous
	// 	$logged = false;
	// 	$me = "";
	// 	list($token, $expires_in) = Helper::getClientSpotifyToken();
	// }
	
	
	foreach ($tracks as $track) {
		$total += $track->duration_ms/1000/60;
	}
	
	$limit = 15;
	while ($total / 60 < $duration && $limit > 0) {
		
		usleep(200);
		$more = getTracksBySeed($genres, $artists, "50", $_SESSION['token']);
		
		foreach ($more as $track) {
			$total += $track->duration_ms/1000/60;
		}
		
		$tracks = array_merge($tracks, $more);
		$limit--;
		if ($limit == 0) break;
	}
	$name = isset($_REQUEST['motivo']) ? $_REQUEST['motivo'] : 'Minha Playlist';
	
	// // create playlist
	// $list = Playlist::create(['name' => $name]);     			/// salva no banco
	
	// attach tracks
	$ids = array();
	foreach($tracks as $track) {
		$ids[] = $track->id;
		
		// $t = Track::firstOrCreate(['spotify' => $track->id]);
		// $list->tracks()->save($t);         						//////// salva faixa de musica
	}
	
	// save playlist on spotify
	if ($_SESSION['spotify_user']) {
		
		$playlist = createPlaylist($_SESSION['spotify_user']->id, "Encontros Crystal " . $name, $_SESSION['token']);
		
		$part = array_slice($ids, 0, 100);
		
		addTracksToPlaylist($_SESSION['spotify_user']->id, $playlist->id, $part, $_SESSION['token']);
		
		if (count($ids) > 100) {
			$part = array_slice($ids, 100, 100);
			addTracksToPlaylist($_SESSION['spotify_user']->id, $playlist->id, $part, $_SESSION['token']);
		}
		if (count($ids) > 200) {
			$part = array_slice($ids, 200, 100);
			addTracksToPlaylist($_SESSION['spotify_user']->id, $playlist->id, $part, $_SESSION['token']);
		}
	}
	
	
	$_SESSION['tracks'] = implode(",", $ids);
	$_SESSION['playlist'] = $playlist->id;
	header("Location: {$_SERVER['HTTP_REFERER']}#home-playlist");
	
} else {
	
	if(isset($_SESSION['login_spotify']))	unset($_SESSION['login_spotify']);
	if(isset($_SESSION['expires']))	 		unset($_SESSION['expires']);
	if(isset($_SESSION['token'])) 			unset($_SESSION['token']);
	
}
?>


<?php 


















// // save playlist on spotify
// if ($logged) {
// 	$list->user_id = $me->id;
// 	$playlist = Helper::createPlaylist($me->spotify, "Encontros Crystal " . $name, $token);
// 	$list->spotify = $playlist->id;
// 	$part = array_slice($ids, 0, 100);
// 	Helper::addTracksToPlaylist($me->spotify, $playlist->id, $part, $token);
// 	if (count($ids) > 100) {
// 		$part = array_slice($ids, 100, 100);
// 		Helper::addTracksToPlaylist($me->spotify, $playlist->id, $part, $token);
// 	}
// 	if (count($ids) > 200) {
// 		$part = array_slice($ids, 200, 100);
// 		Helper::addTracksToPlaylist($me->spotify, $playlist->id, $part, $token);
// 	}
// }
// // save spotify id
// $list->save();
// // implode for player
// $ids = implode(",", $ids);
// // return view
// return view('playlist',['tracks'=>$ids, 'playlist'=>$list, 'logged'=>$logged, 'me'=>$me, 'fresh'=>true, 'player'=>$player]);







?>










<form action="/playlist/make/3">
	<input type="hidden" name="genre" value="Forró,Reggae,Pagode" />
	
	
</form>	





