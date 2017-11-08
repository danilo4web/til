# Update URL
UPDATE wp_options SET option_value = REPLACE(option_value, 'http://meu-projeto.dev', 'http://meu-projeto.com.br') WHERE option_name = 'home' OR option_name = 'siteurl';

# Update Content URL
UPDATE wp_posts SET guid = REPLACE( guid, 'http://meu-projeto.dev', 'http://meu-projeto.com.br');

# Replace just images to new path
UPDATE wp_posts SET post_content = REPLACE( post_content, 'src="http://meu-projeto.dev', 'src="http://meu-projeto.com.br' );

# Replace content
UPDATE wp_posts SET post_content = REPLACE( post_content, 'DEV_TERMS', 'PRODUCTION_TERMS' );

# Update users password
UPDATE wp_users SET user_pass = MD5( 'NEW-PASSWORD' ) WHERE user_login = 'LOGIN';