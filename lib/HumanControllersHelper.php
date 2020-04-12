<?php


namespace lib;


use controllers\BaseController;

class HumanControllersHelper extends BaseControllersHelper {

	private $regions;
	public function __construct(Router $router) {

		parent::__construct($router);

		if (!isset($router->get[ROUTE_PARAM_NAME])) {

			throw new \Exception('Not set url param : ' . ROUTE_PARAM_NAME);
		}

		$regions = explode('/', $router->get[ROUTE_PARAM_NAME]);
		if (empty($regions[count($regions) - 1])) {
			unset($regions[count($regions) - 1]);
		}

		$regions = array_map(function ($r) {

			return preg_replace('/[\'\\\*\.]/', '', $r);
		}, $regions);
		$this->regions = $regions;
	}

	public function execController() {

		$controller = $this->getController();
		$data = $this->execControllerAction($controller);
		return $data;
	}

	protected function getController() {

		$controllerNs = 'controllers\\';
		$controller = null;

		foreach ($this->regions as &$region) {

			$controllerName = $controllerNs . ucfirst($region);
			if (class_exists($controllerName)) {

				$controller = new $controllerName($this);
				break;
			}
		}

		if (is_null($controller)) {

			throw new \Exception('Entity not found', '404');
		}

		return $controller;
	}

	protected function execControllerAction(BaseController &$controller) {

		foreach ($this->regions as &$region) {

			if (method_exists($controller, $region)) {
				return $controller->$region();
			}
		}

		return $controller->index();
	}
}