<?php


namespace lib;


class Router {

	private $get;
	private $post;

	public function __construct() {

		$this->get = $_GET;
		$this->post = $_POST;
	}

	public function execController() {

		$controllersHelper = new GetControllersHelper($this);
		if (defined('HRU')) {
			$controllersHelper = new HumanControllersHelper($this);
		}
		$controllersHelper->execController();
	}

	public function __set($param, $val) {

		$this->$param = $val;
	}

	public function __get($param) {

		if (isset($this->$param)) {
			return $this->$param;
		}

		return false;
	}
}