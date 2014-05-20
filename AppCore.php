<?php
class AppCore {
	public function run() {
		$URL = explode('/', $_SERVER['REQUEST_URI']);
		if (@$URL[1]) {
			//Create controllers name from url(Controller + Name);
			$controllerName = 'Controller' . strtoupper(substr($URL[1], 0, 1)) . substr($URL[1], 1); 
		} else {
			$controllerName = 'ControllerIndex';
		}

		if (@$URL[2]) {
			//Create actions name from url(action + Name)
			$actionName = 'action' . strtoupper(substr($URL[2], 0, 1)) . substr($URL[2], 1);
		} else {
			$actionName = 'actionDefault';
		}

		if (@$URL[3]) {
			$param = $URL[3];
		}

		$Controller = new $controllerName($this->DB);
		if (method_exists($Controller, $actionName)) {
			if (@$param) {
				if (@$param == '') {
					header('Location: /404');
				} else {
					@$Controller->$actionName($this->DB, $param);
				}
			} else {
				@$Controller->$actionName($this->DB);
			}
		} else {
			header('Location: /404');
		}
	}
}
?>