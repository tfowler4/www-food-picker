<?php

/**
 * server object
 */
class Server extends AbstractModel {
    public $id;
    public $name;
    public $profileLink;

    public function __construct($data) {
        $this->id          = $data['id'];
        $this->name        = $data['name'];
        $this->profileLink = SITE_URL . 'server/' . $data['id'] . '/' . urlencode($data['name']);
    }
}