<?php


namespace controllers;


use lib\Router;

abstract class BaseController {

	protected $router;
	protected $model;

	public function __construct(Router $router) {

		$this->router = $router;
	}

	protected function loadModel($className) {

		$modelName = 'models\\' . ucfirst($className);
		$this->model = new $modelName();
	}

	public function includeTemplate($dir, $name, $params) {

		extract($params);
		require_once TEMPLATES_DIR . '/' . $dir . '/' . $name.'.tpl';
	}

	abstract function index();
}