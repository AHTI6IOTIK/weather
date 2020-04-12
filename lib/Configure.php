<?php


namespace lib;


class Configure {

	private static $dirConf;
	private static $params;

	public static function get(string $paramName) {

		if (empty(self::$params)) {

			self::loadParams();
		}

		return self::$params[$paramName];
	}

	public static function init() {

		self::$dirConf = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR;

		if (file_exists(self::$dirConf . '/api_keys.php')) {

			require_once self::$dirConf . '/api_keys.php';
		}
		self::loadParams();
	}

	private static function loadParams() {

		foreach (self::getConfFileNameMap() as $configName) {

			$configPath = self::$dirConf . '/' . $configName;
			if (file_exists($configPath)) {

				self::$params = require_once $configPath;
				break;
			}
		}
		self::defineConstants();
	}

	private static function defineConstants() {

		if (!empty(self::$params['constants'])) {

			foreach (self::$params['constants'] as $constName => &$constValue) {

				preg_match('/%(.+)%/', $constValue, $match );
				if (count($match) > 0 && isset(self::$params['constants'][$match[1]])) {

					$constValue = str_replace($match[0], self::$params['constants'][$match[1]], $constValue);
				}

				if (!defined($constName)) {
					define($constName, $constValue);
				}
			}
		}
	}

	private static function getConfFileNameMap() {

		return [
			'conf.prod.php',
			'conf.test.php',
			'conf.dev.php',
		];
	}
}