<?php

/**
 * guild profile object
 */
class GuildProfile {
    public $id;
    public $name;
    public $server;
    public $region;
    public $country;
    public $countryAbbreviation;
    public $active;
    public $dateAdded;
    public $profileLink;

    public function __construct($data) {
        $this->id                  = $data['id'];
        $this->name                = $data['name'];
        $this->server              = $data['server'];
        $this->region              = $data['region'];
        $this->country             = $data['country'];
        $this->countryAbbreviation = strtolower($data['country_abbreviation']);
        $this->dateAdded           = date("m/d/Y", strtotime($data['date_added']));
        $this->active              = $data['active'];
        $this->profileLink         = SITE_URL . 'guild/profile/' . $data['id'] . '/' . urlencode($data['name']);
    }
}