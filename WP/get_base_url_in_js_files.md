# JS INSTANCE (on functions.php)
wp_register_script('search-js',get_template_directory_uri().'/libs/js/search.js',array(),NULL,true);
wp_enqueue_script('search-js');
	
# BASE URL
$wnm_custom = array( 'base_url' => get_home_url('url') );
wp_localize_script( 'search-js', 'wnm_custom', $wnm_custom );


alert(wnm_custom.base_url);
