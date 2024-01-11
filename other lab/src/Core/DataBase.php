<?php
namespace src\Core;

class DataBase extends \SQLite3
{
	function __construct($file)
	{
		$this->open($file);
	}
}
