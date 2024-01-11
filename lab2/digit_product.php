<?php

class DigitProduct extends Product
{
    function __construct($price) 
    {
        parent::__construct($price);
    }

    function get_price() 
    {
        return $this->price / 2;
    }
}