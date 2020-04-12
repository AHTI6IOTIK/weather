<?php


namespace lib\openweathermap;


use lib\interfaces\IObjectToArray;
use lib\objectUtils\ObjectToArray;

class Weather implements IObjectToArray {

	use ObjectToArray;

	private $id;
	private $main;
	private $description;
	private $icon;
	private $iconPath;

	public function __construct($arWeather) {

		$this->id = $arWeather['id'];
		$this->main = $arWeather['main'];
		$this->description = $arWeather['description'];
		$this->icon = $arWeather['icon'];
		$this->iconPath = $this->getIconPath();
	}

	public function getIconPath() {

		$path = sprintf('http://openweathermap.org/img/wn/%s.png', $this->icon);
		return $path;
	}
}