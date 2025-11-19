<?php

class House {
    public $name;
    public $price;
    public $address;
    public $phone;
    public $image;
    public $beds;
    public $baths;

    public function __construct($name, $price, $address, $phone, $image, $beds, $baths) {
        $this->name = $name;
        $this->price = $price;
        $this->address = $address;
        $this->phone = $phone;
        $this->image = $image;
        $this->beds = $beds;
        $this->baths = $baths;
    }
}
