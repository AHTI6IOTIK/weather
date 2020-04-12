<?php


namespace controllers;


use lib\Router;

class Weather extends BaseController {

	public function __construct(Router $router) {

		parent::__construct($router);
		$this->loadModel('Weather');
	}

	public function index() {

		$city = 'Moscow';
		$region = '77';
		$country = 'ru';
		if (isset($this->router->get['formWeather'])) {
			if (!empty($this->router->get['weather-city'])) {

				$city = strip_tags(trim($this->router->get['weather-city']));
			}
			if (!empty($this->router->get['weather-country'])) {

				$country = strip_tags(trim($this->router->get['weather-country']));
			}
			if (!empty($this->router->get['weather-region'])) {

				$region = strip_tags(trim($this->router->get['weather-region']));
			}
		}

		$weatherMap  = $this->model->getWeather($city, $region, $country);
		$data = $weatherMap->convertToArray();

		$data['weatherCity'] = $city;
		$data['weatherRegion'] = $region;
		$data['weatherCountry'] = $country;

		$data['action'] = '/?route=weather';
		$this->includeTemplate('weather', 'index', $data);
	}
}