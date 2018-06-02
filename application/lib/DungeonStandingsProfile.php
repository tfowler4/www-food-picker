<?php

/**
 * dungeon standings profile object
 */
class DungeonStandingsProfile {
    public $id;
    public $guildId;
    public $name;
    public $server;
    public $region;
    public $regionAbbreviation;
    public $country;
    public $active;
    public $progression;
    public $worldFirsts;
    public $regionFirsts;
    public $serverFirsts;
    public $last14;
    public $last30;
    public $recentActivity;
    public $profileLink;

    public function __construct($data) {
        $this->id                 = $data['id'];
        $this->guildId            = $data['guild_id'];
        $this->name               = $data['name'];
        $this->server             = $data['server'];
        $this->region             = $data['region'];
        $this->regionAbbreviation = $data['region_abbreviation'];
        $this->country            = strtolower($data['country']);
        $this->active             = $data['active'];
        $this->worldFirsts        = $data['world_firsts'];
        $this->regionFirsts       = $data['region_firsts'];
        $this->serverFirsts       = $data['server_firsts'];
        $this->last14             = $data['last_14'] . '/' . $data['num_of_encounters'];
        $this->last30             = $data['last_30'] . '/' . $data['num_of_encounters'];
        $this->recentActivity     = $data['recent_activity'];
        $this->progression        = $data['num_of_complete'] . '/' . $data['num_of_encounters'];
        $this->profileLink        = SITE_URL . 'guild/profile/' . $data['guild_id'] . '/' . urlencode($data['name']);
    }
}