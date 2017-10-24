<?php

App::uses('ClassRegistry', 'Utility');
class DbRoute extends CakeRoute {
	
	protected function returnSlug($slug) {
		if (empty($slug)) {
			return '/';
		}
		
		return $slug;
	}
	
	protected function getPass($slug) {
		if (preg_match('/^(\/).{1,}/',$slug)) {
			$slug = substr($slug, 1);
		}
		if (preg_match('/.{1,}(\/)$/',$slug)) {
			$slug = substr($slug, 0, -1);
		}
		return explode('/', $slug);
	}
	
	public function parse($slug) {
		$route = ClassRegistry::init('Route');
		$slug = $this->returnSlug($slug);
		
		// verifica se existe routa e parametros na URL
		if(substr_count($slug, "/") > 1) {
			$exploded_slug = explode("/", $slug);
			unset($exploded_slug[0]);
			
			// troca parametros
			foreach($exploded_slug as $key => $value) {
				if(empty($value)) {
					unset($exploded_slug[$key]);
				} elseif(preg_match('/^[1-9][0-9]*$/', $value)) {
					unset($exploded_slug[$key]);
					$param[] = $value;
				}
			}
			
			// Slug (busca no banco)
			$slug_needed = "/" . implode("/", $exploded_slug);
		}
		
		if(isset($slug_needed) && $slug_needed) {
			$url = $route->find('first', array('conditions' => array('Route.slug like' => $slug_needed . "%")));
		} else {
			$url = $route->find('first',array('conditions'=>array('Route.slug' => $slug)));
		}
		
		if(empty($url)) {
			return false;
		} else {
			$parse['controller'] = $url['Route']['controller'];
			$parse['action'] = $url['Route']['action'];
			$parse['pass'] = $this->getPass($url['Route']['pass']);

			if(isset($param) && $param) {
				foreach($param as $key => $value)
					$parse['pass'][] = $value;
			}
			
			if (empty($parse['pass'])) {
				unset($parse['pass']);
			}
			return $parse;
		}
		
	}
}