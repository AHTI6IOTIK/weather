<?php


namespace lib;

use controllers\BaseController;

abstract class BaseControllersHelper {

	protected $router;

	public function __construct(Router $router) {

		$this->router = $router;
	}

	abstract public function execController();

	abstract protected function getController();

	abstract protected function execControllerAction(BaseController &$controller);
}