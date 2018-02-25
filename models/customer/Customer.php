<?php

namespace app\models\customer;

class Customer {

    public $name;

    public function __construct($name)
    {
        $this->name= $name;
    }
}