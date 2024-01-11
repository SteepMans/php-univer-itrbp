<?php
require_once __DIR__ . '/vendor/autoload.php';

class ClassAutoloader {
	public function __construct() {
		spl_autoload_register(function ($class_name) {
			$class = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);
			$class = str_replace('_', DIRECTORY_SEPARATOR, $class_name);
	
			$class = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';

			if (file_exists($class)) {
				include $class;
			}
		});
	}
}

new ClassAutoloader();