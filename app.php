<?php

spl_autoload_register(function ($className) {

	$className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
	$file_name = __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';

	require_once $file_name;
});

try {

	\lib\Configure::init();
	$router = new \lib\Router();
	$router->execController();
} catch (Exception $exception) {

	var_dump($exception->getMessage());
	var_dump($exception->getTrace());
}
