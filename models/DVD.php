<?php

namespace models;

class DVD extends Product {
    protected $size;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->size = $data->size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function __toString()
    {
        return parent::__toString().' '.$this->getSize();
    }
}