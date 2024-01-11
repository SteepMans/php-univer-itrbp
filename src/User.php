<?php
namespace src;

class User
{
	public string $id;
	public string $name;
	public string $surname;

    public function __construct($id, $name, $surname) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
    }

	public function __toString() {
        return "UUID: {$this->id}, Name: {$this->name}, SurName: {$this->surname}";
    }
}

