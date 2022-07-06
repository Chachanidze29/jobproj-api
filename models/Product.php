<?php

namespace models;

abstract class Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    public function __construct($data)
    {
        $this->sku = $data->sku;
        $this->name = $data->name;
        $this->price = $data->price;
        $this->type = $data->type;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function __toString()
    {
        return $this->getSku().' '.$this->getName().' '.$this->getPrice().' '.$this->getType();
    }
}