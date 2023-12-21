<?php
require_once __DIR__ . '/vendor/autoload.php';

const linux_os_name = "linux";
const macos_os_name = "macos";
const windows_os_name = "windows";

class ClassAutoloader {
	public function __construct() {
		spl_autoload_register(array($this, 'loader'));
	}
	private function loader($class_name) {
		$os_name = strtolower(php_uname('s'));
		$class_name = str_replace(array('/', '\\'), '/', $class_name);
	
		$pattern = '/[A-Z][a-zA-Z]*(_)[A-Z][a-zA-Z]*($|\/)/';
	
		preg_match_all($pattern, $class_name, $out, PREG_OFFSET_CAPTURE);
	
		foreach ($out[1] as $value) {
			$replacement = '/';
	
			$class_name = substr_replace($class_name, $replacement, $value[1], 1);
		}
	
		if (str_contains($os_name, linux_os_name) or str_contains($os_name, macos_os_name)) {
			$class_name = str_replace(array('/', '\\'), '/', $class_name);
		} elseif (str_contains($os_name, windows_os_name)) {
			$class_name = str_replace(array('/', '\\'), '/', $class_name);
		}
	
		include getcwd() . "/src/" . $class_name . '.php';
	}
}

new ClassAutoloader();