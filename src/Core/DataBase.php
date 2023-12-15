<?php
class DataBase extends SQLite3
{
	function __construct($file)
	{
		$this->open($file);
	}
}
