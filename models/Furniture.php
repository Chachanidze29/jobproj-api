<?php

namespace models;

class Furniture extends Product {
    protected $height;
    protected $width;
    protected $length;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->height = $data->height;
        $this->width = $data->width;
        $this->length = $data->length;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getDimensions() {
        return $this->getHeight().'X'.$this->getLength().'X'.$this->getWidth();
    }

    public function __toString()
    {
        return parent::__toString().' '.$this->getDimensions();
    }
}