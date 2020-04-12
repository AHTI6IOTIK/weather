<?php


namespace lib\objectUtils;


use lib\interfaces\IObjectToArray;
use lib\openweathermap\Weather;

trait ObjectToArray {

	private $arClass = [];
	public function convertToArray() {

		$a = new \ReflectionClass($this);
		$this->arClass = $this->construct($a->getProperties());

		return $this->arClass;
	}

	private function construct($arProps) {

		$buf = [];
		foreach ($arProps as $property) {
			$propName = $property->name;

			if ($propName === 'arClass') {

				continue;
			}

			if (is_array($this->$propName)) {

				foreach ($this->$propName as $key => $val) {

					if (is_object($val) && ($val instanceof IObjectToArray)) {

						$buf[$propName][$key] = $val->convertToArray();
					}
				}
				continue;
			}

			$buf[$propName] = $this->$propName;
		}

		return $buf;
	}
}