<?php


namespace models;


use lib\openweathermap\WeatherMap;
use utils\RequestHelper;

class Weather {

	private $requestHelper;

	public function __construct() {

		$this->requestHelper = new RequestHelper();
	}

	public function getWeather($city, $region, $country) {

		$place = sprintf('%s,%s,%s', $city, $region, $country);

		if (!(intval($region) > 0)) {
			return ['isError' => true, 'message' => 'enter the region in numbers'];
		}

		$response = $this->requestHelper
			->setScheme('https')
			->setHost('api.openweathermap.org')
			->setQueryMethod('POST')
			->setPath('/data/2.5/weather')
			->setGetParams(['q' => $place, 'APPID' => WEATHER_API_KEY])
			->send();

		return WeatherMap::createFromJson($response);
	}
}