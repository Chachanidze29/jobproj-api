<?php

namespace models;

class Book extends Product {
    protected $weight;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->weight = $data->weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function __toString()
    {
        return parent::__toString().' '.$this->getWeight();
    }
}