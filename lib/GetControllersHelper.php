<?php


namespace lib;


use controllers\BaseController;

class GetControllersHelper extends BaseControllersHelper {

	protected $controller;
	protected $action;

	public function __construct(Router $router) {

		parent::__construct($router);

		$this->controller = ucfirst(DEFAULT_ROUTE);
		$this->action = 'index';
		if (isset($this->router->get[ROUTE_PARAM_NAME])) {

			$controllerParam = explode('/', $this->router->get[ROUTE_PARAM_NAME]);
			$this->controller = ucfirst($controllerParam[0]) ?? 'Weather';
			$this->action = $controllerParam[1] ?? 'index';
		}
	}

	public function execController() {

		$controller = $this->getController();
		$data = $this->execControllerAction($controller);
		return $data;
	}

	protected function getController() {

		$controllerName = 'controllers\\'.$this->controller;
		if (class_exists($controllerName)) {

			$controller = new $controllerName($this->router);
		}

		if (is_null($controller)) {

			throw new \Exception('Entity not found', '404');
		}

		return $controller;
	}

	protected function execControllerAction(BaseController &$controller) {

		if (method_exists($controller, $this->action)) {

			return call_user_func([$controller, $this->action]);
		}

		return $controller->index();
	}
}