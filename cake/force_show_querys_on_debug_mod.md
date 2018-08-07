	# include it on AppModel.php
	public function afterFind($model, $results) {
		

		if(Configure::read('debug') == 2) {
			var_dump($this->getDataSource()->showLog());
		}

		return parent::afterFind($model, $results);
	}
