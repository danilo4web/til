<?php

    class ShowPosts {

        public function __sincronizaFacebook() {
            $rede_social = $this->TipoRedesocial->find('first', array('conditions' => array('id' => '1')));
            
            $config = '[
                {"desc":"app_id","valor":"0101010101010101"},
                {"desc":"app_secret","valor":"0101010101010101"},
                {"desc":"default_graph_version","valor":"v2.10"},
                {"desc":"default_access_token","valor":"EAHUSHAIUHSAJSKAJSHAHSNOAIUHSONAISNOAISUNOASIUO"}
            ]';
    
            foreach(json_decode($config) as $config) {
                $var = $config->desc;
                $$var = $config->valor;
            }
            
            $count_sinc = 0;
            $usuario = $rede_social['TipoRedesocial']['usuario'];
            
            // instancia
            $fb = new Facebook\Facebook(array(
                'app_id'     => $app_id,
                'app_secret' => $app_secret,
                'default_graph_version' => $default_graph_version,
                'default_access_token' => $default_access_token,
            ));
            
            $response = $fb->get('/me/posts', $default_access_token);
            $feedEdge = $response->getGraphEdge()->asArray();
    
            
            foreach ($feedEdge as $conteudo) {
    
                if(isset($conteudo['message']) && !empty($conteudo['message'])) {
                    $created = get_object_vars($conteudo['created_time']);
                    
                    $inclusao = array(
                        'codigo_externo' => current(array_reverse(explode("_", $conteudo['id']))),
                        'mensagem' => $this->__summarize($conteudo['message'], 200, '(...)'),
                        'mensagem_integra' => $conteudo['message'],
                        'data_postagem' => substr($created['date'], 0, 19),
                        'fk_tipo_redesocial' => 1,
                    );
                    
                    if(!$this->Postagem->find('first', array('conditions' => array('codigo_externo' => $inclusao['codigo_externo'])))) {
                        
                        $this->Postagem->create();
                        if($this->Postagem->save(array('Postagem' => $inclusao))) {
                            $count_sinc++;
                            
                            $response = $fb->get($conteudo['id'] . '/attachments', $default_access_token);
                            $node = $response->getDecodedBody();
                            
                            foreach($node['data'] as $k_file => $file) {
                                if(isset($file['subattachments']) && count($file['subattachments'])) {
                                    foreach($file['subattachments']['data'] as $sub_file) {
                                        
                                        $path_url = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
                                        $nome_da_imagem = current(explode('?', current(array_reverse(explode('/', $sub_file['media']['image']['src'])))));
    
                                        $path_img = $_SERVER['DOCUMENT_ROOT'] . "{$path_url}/files/rede_social/" . $nome_da_imagem;							
                                        file_put_contents($path_img, file_get_contents($sub_file['media']['image']['src']));
    
                                        $inclusao = array(
                                            'codigo_externo' => isset($sub_file['target']['id']) ? $sub_file['target']['id'] : null,
                                            'id_postagem' => $conteudo['id'],
                                            'descricao' => isset($sub_file['title']) ? $file['title'] : '',
                                            'src_media' => $nome_da_imagem,
                                            'url_media' => $sub_file['target']['url'],
                                            'tipo_media' => $sub_file['type']
                                        );
                                        
                                        $this->MediaPostagem->create();
                                        if(!$this->MediaPostagem->save(array('MediaPostagem' => $inclusao))) {
                                            pr($this->MediaPostagem->validationErrors);
                                            pr($inclusao);
                                            exit('Houve um erro ao incluir: MediaPostagem');
                                        }
                                    }
                                    
                                } else {
    
                                    $path_url = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
                                    $nome_da_imagem = current(explode('?', current(array_reverse(explode('/', $file['media']['image']['src'])))));
                                    $path_img = $_SERVER['DOCUMENT_ROOT'] . "{$path_url}/files/rede_social/" . $nome_da_imagem;							
                                    file_put_contents($path_img, file_get_contents($file['media']['image']['src']));
    
                                    $inclusao = array(
                                        'codigo_externo' => $file['target']['id'],
                                        'id_postagem' => $this->Postagem->id,
                                        'descricao' => isset($file['title']) ? $file['title'] : '',
                                        'src_media' => $nome_da_imagem,
                                        'url_media' => $file['target']['url'],
                                        'tipo_media' => $file['type']
                                    );
                                    
                                    $this->MediaPostagem->create();
                                    if(!$this->MediaPostagem->save(array('MediaPostagem' => $inclusao))) {
                                        pr($this->MediaPostagem->validationErrors);
                                        pr($inclusao);
                                        exit('Houve um erro ao incluir: MediaPostagem');
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
            return $count_sinc;
        }
            


        public function __sincronizarInstagram() {
            $rede_social = $this->TipoRedesocial->find('first', array('conditions' => array('id' => '3')));
            

            $config = '[
                {"desc":"USER_ID","valor":"610665870000019"},
                {"desc":"CLIENT_ID","valor":"0a96109e4d24498a7s98ad7a0b992ab810"},
                {"desc":"CLIENT_SECRET","valor":"ecb7e2623f624109bd273fc34c0419dd"},
                {"desc":"REDIRECT_URI","valor":"http:\/\/www.dominio.com.br\/index.php"},
                {"desc":"ACCESS_TOKEN","valor":"61987987019.0a96109.94e0cbf38f314d4db498798678af079"}
            ]';
            
            
            foreach(json_decode($config) as $config) {
                $var = $config->desc;
                $$var = $config->valor;
            }
            
            $count_sinc = 0;
            $usuario = $rede_social['TipoRedesocial']['usuario'];
            
            $url = "https://api.instagram.com/v1/users/" . $USER_ID . "/media/recent/?access_token=" . $ACCESS_TOKEN;
            // $url = "https://api.instagram.com/v1/users/search?q=danilo&access_token=" . $ACCESS_TOKEN;
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            $result = curl_exec($ch);
            curl_close($ch);
            
            $result = json_decode($result);
    
            foreach ($result->data as $conteudo) {
                $mensagem = isset($conteudo->caption->text) ? $conteudo->caption->text : '';
                
                $inclusao = array(
                        'codigo_externo' => current(explode("_", $conteudo->id)),
                        'mensagem' => $this->__summarize($mensagem, 200, '(...)'),
                        'mensagem_integra' => $mensagem,
                        'data_postagem' => date('Y-m-d H:i:s', $conteudo->created_time),
                        'url' => $conteudo->link,
                        'fk_tipo_redesocial' => 3,
                );
                
                if(!$this->Postagem->find('first', array('conditions' => array('codigo_externo' => $inclusao['codigo_externo'])))) {
                    
                    $this->Postagem->create();
                    if($this->Postagem->save(array('Postagem' => $inclusao))) {
                        $count_sinc++;
                        
                        if(isset($conteudo->carousel_media) && count($conteudo->carousel_media)) {
                            
                            foreach($conteudo->carousel_media as $media) {
    
                                $path_url = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
                                $nome_da_imagem = current(array_reverse(explode('/', $media->images->standard_resolution->url)));
                                $path_img = $_SERVER['DOCUMENT_ROOT'] . "{$path_url}/files/rede_social/" . $nome_da_imagem;							
                                file_put_contents($path_img, file_get_contents($media->images->standard_resolution->url));
    
                                $inclusao = array(
                                        'codigo_externo' => current(explode("_", $conteudo->id)),
                                        'id_postagem' => $this->Postagem->id,
                                        'descricao' => '',
                                        'src_media' => $nome_da_imagem,
                                        'url_media' => $conteudo->link,
                                        'tipo_media' => $media->type
                                );
                                
                                $this->MediaPostagem->create();
                                if(!$this->MediaPostagem->save(array('MediaPostagem' => $inclusao))) {
                                    pr($this->MediaPostagem->validationErrors);
                                    pr($inclusao);
                                    
                                    exit('Houve um erro ao Incluir: MediaPostagem');
                                }
                            }
                        } else {
    
                            $path_url = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
                            $nome_da_imagem = current(array_reverse(explode('/', $conteudo->images->standard_resolution->url)));
                            $path_img = $_SERVER['DOCUMENT_ROOT'] . "{$path_url}/files/rede_social/" . $nome_da_imagem;							
                            file_put_contents($path_img, file_get_contents($conteudo->images->standard_resolution->url));
                            
                            $inclusao = array(
                                    'codigo_externo' => current(explode("_", $conteudo->id)),
                                    'id_postagem' => $this->Postagem->id,
                                    'descricao' => '',
                                    'src_media' => $nome_da_imagem,
                                    'url_media' => $conteudo->link,
                                    'tipo_media' => $conteudo->type
                            );
                            
                            $this->MediaPostagem->create();
                            if(!$this->MediaPostagem->save(array('MediaPostagem' => $inclusao))) {
                                pr($this->MediaPostagem->validationErrors);
                                pr($inclusao);
                                
                                exit('Houve um erro ao Incluir: MediaPostagem');
                            }
                        }
                    } else {
                        exit('error');
                    }
                }
            }
            
            return $count_sinc;
        }

        public function __sincronizaTwitter() {
            $rede_social = $this->TipoRedesocial->find('first', array('conditions' => array('id' => '2')));
            
            foreach(json_decode($rede_social['TipoRedesocial']['config']) as $config) {
                $var = $config->desc;
                $$var = $config->valor;
            }
            
            $count_sinc = 0;
            $usuario = $rede_social['TipoRedesocial']['usuario'];
            
            // Set access tokens <https://dev.twitter.com/apps/>
            $settings = array(
                'oauth_access_token' => $oauth_access_token,
                'oauth_access_token_secret' => $oauth_access_token_secret,
                'consumer_key' => $consumer_key,
                'consumer_secret' => $consumer_secret
            );
            
            // Set API request URL and timeline variables if needed <https://dev.twitter.com/docs/api/1.1>
            $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
            $tweetCount = 2000;
            
            $getfield = '?screen_name=' . $usuario. '&count=' . $tweetCount;
            $twitter = new TwitterAPITimeline($settings);
            
            $json = $twitter->setGetfield($getfield)
                            ->buildOauth($url, 'GET')
                            ->performRequest();
            
            foreach (json_decode($json, true) as $tweet) {
                
                $inclusao = array(
                    'codigo_externo' => $tweet['id'],
                    'mensagem' => $tweet['text'],
                    'data_postagem' => date('Y-m-d H:i:s', strtotime($tweet['created_at'])),
                    'fk_tipo_redesocial' => 2,
                );
                    
                if(!$this->Postagem->find('first', array('conditions' => array('codigo_externo' => $inclusao['codigo_externo'])))) {
                        
                    $this->Postagem->create();
                    if($this->Postagem->save(array('Postagem' => $inclusao))) {
                        $count_sinc++;
                        
                        if(isset($tweet['extended_entities']) && count($tweet['extended_entities'])) {
                            foreach($tweet['extended_entities']['media'] as $media) {
                                
                                $inclusao = array(
                                    'codigo_externo' => $media['id'],
                                    'id_postagem' => $tweet['id'],
                                    'descricao' => '',
                                    'src_media' => $media['media_url'],
                                    'url_media' => $media['url'],
                                    'tipo_media' => $media['type']
                                );
                                
                                $this->MediaPostagem->create();
                                if(!$this->MediaPostagem->save(array('MediaPostagem' => $inclusao))) {
                                    pr($this->MediaPostagem->validationErrors);
                                    pr($inclusao);
                                    exit('Houve um erro ao Incluir: MediaPostagem');
                                }
                            } 
                        }
                        
                        if(isset($tweet['entities']['user_mentions']) && count($tweet['entities']['user_mentions'])) {
                            foreach($tweet['entities']['user_mentions'] as $user) {
                                
                                $inclusao = array(
                                    'codigo_externo' => $user['id'],
                                    'id_postagem' => $tweet['id'],
                                    'nome' => $user['screen_name']
                                );
                                
                                $this->UsuarioMencionadoPostagem->create();
                                if(!$this->UsuarioMencionadoPostagem->save(array('UsuarioMencionadoPostagem' => $inclusao))) {
                                    pr($this->UsuarioMencionadoPostagem->validationErrors);
                                    pr($inclusao);
                                    exit('Houve um erro ao Incluir: UsuarioMencionadoPostagem');
                                }
                            }
                        }
                    }
                }
            }
            
            return $count_sinc;
        }
    }
    