<?php

class WeightProduct extends Product
{
    public $amount;

    function __construct($price, $amount) 
    {
        parent::__construct($price);
        $this->amount = $amount;
    }

    function get_price() 
    {
        return $this->price * $this->amount;
    }
}