<?php

class PhysicalProduct extends Product
{
    public $count;

    function __construct($price, $count) 
    {
        parent::__construct($price);
        $this->count = $count;
    }

    function get_price() 
    {
        return $this->price * $this->count;
    }
}