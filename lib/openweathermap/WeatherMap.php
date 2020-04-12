<?php
// https://openweathermap.org/weather-data

namespace lib\openweathermap;


use lib\interfaces\IObjectToArray;
use lib\objectUtils\ObjectToArray;

class WeatherMap implements IObjectToArray {

	use ObjectToArray;

	private $cityName;
	private $temp;
	private $feelsLikeTemp;
	private $speedWind;
	private $humidity;
	private $pressure;

	private $isRain;
	private $isSnow;
	private $isError;
	private $errorMessage;

	private $weathers;

	private $weatherTip = '';

	public function __construct() {

		$this->weathers = [];
	}

	public static function createFromJson($json) {

		$object = new static();
		$arWeather = json_decode($json, 1);

		if (isset($arWeather['cod']) && intval($arWeather['cod']) !== 200) {

			$object->setIsError(true);
			$object->setErrorMessage($arWeather['message']);
		}

		if (isset($arWeather['weather'])) {

			foreach ($arWeather['weather'] as $weather) {
				$object->addWeather((new Weather($weather)));
			}
		}

		if (isset($arWeather['name'])) {

			$object->setCityName($arWeather['name']);
		}

		if (isset($arWeather['name'])) {

			$object->setTemp($arWeather['main']['temp']);
		}

		if (isset($arWeather['name'])) {

			$object->setPressure($arWeather['main']['pressure']);
		}

		if (isset($arWeather['name'])) {

			$object->setFeelsLikeTemp($arWeather['main']['feels_like']);
		}

		if (isset($arWeather['name'])) {

			$object->setHumidity($arWeather['main']['humidity']);
		}

		if (isset($arWeather['name'])) {

			$object->setSpeedWind($arWeather['wind']['speed']);
		}

		if (isset($arWeather['name'])) {

			$object->setIsRain(isset($arWeather['rain']));
		}

		if (isset($arWeather['name'])) {

			$object->setIsSnow(isset($arWeather['snow']));
		}

		$object->setWeatherTip();

		return $object;
	}

	public function setWeatherTip() {

		if (isset($this->speedWind) && $this->speedWind > 10) {
			$this->weatherTip .= 'Stay away from unstable structures. ';
		}

		if (isset($this->feelsLikeTemp) && $this->feelsLikeTemp < 10) {
			$this->weatherTip .= 'It may be cold, dress warmer. ';
		}

		if ($this->isRain) {
			$this->weatherTip .= 'It may rain, take an umbrella. ';
		}

		if ($this->isSnow) {
			$this->weatherTip .= 'It may snow, be careful driving. ';
		}
	}

	public function addWeather(Weather $weather) {

		$this->weathers[] = $weather;
	}

	public function setCityName($cityName) {

		$this->cityName = $cityName;
	}

	public function setTemp($temp) {

		$temp = $temp - 273;
		$this->temp = $temp;
	}

	public function setPressure($pressure) {

		$pressure = number_format(($pressure / 1.332), 2);
		$this->pressure = $pressure;
	}

	public function setSpeedWind($speedWind) {

		$this->speedWind = $speedWind;
	}

	public function setFeelsLikeTemp($temp) {

		$temp = $temp - 273;
		$this->feelsLikeTemp = $temp;
	}

	public function setHumidity($humidity) {

		$this->humidity = $humidity;
	}

	public function setIsSnow($isSnow) {

		$this->isSnow = $isSnow;
	}

	public function setIsRain($isRain) {

		$this->isRain = $isRain;
	}

	public function getWeathers() {

		return $this->weathers;
	}

	public function setIsError($isError) {

		$this->isError = $isError;
	}

	public function setErrorMessage($errorMessage) {

		$this->errorMessage = $errorMessage;
	}
}
