<?php

/**
 * country object
 */
class Country extends AbstractModel {
    public $id;
    public $name;

    public function __construct($data) {
        $this->id   = $data['id'];
        $this->name = $data['name'];
    }
}