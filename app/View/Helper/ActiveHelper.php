<?php

App::uses('AppHelper', 'View/Helper');

class ActiveHelper extends AppHelper {

	public function add($page, $has_class = false) {

		$controller = $this->request->params['controller'];

		if ($page == $controller):
			if (!$has_class):
				echo ' class="active"';
			else:
				echo ' active';
			endif;
		endif;

	}

}