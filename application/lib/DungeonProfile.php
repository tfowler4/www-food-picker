<?php

/**
 * dungeon profile object
 */
class DungeonProfile {
    public $id;
    public $name;
    public $tier;
    public $raidSize;
    public $numOfEncounters;
    public $numOfCompletions;
    public $dateAvailable;
    public $firstGuildClear;
    public $recentGuildClear;
    public $profileLink;
    public $standingsLink;

    public function __construct($data) {
        $this->id               = $data['id'];
        $this->name             = $data['name'];
        $this->tier             = $data['tier'];
        $this->raidSize         = $data['raid_size'];
        $this->numOfEncounters  = $data['num_of_encounters'];
        $this->numOfCompletions = $data['num_of_completions'];
        $this->dateAvailable    = date("m/d/Y", strtotime($data['date_available']));
        $this->standingsLink    = SITE_URL . 'standings/dungeon/' . $data['id'] . '/' . urlencode($data['name']);
        $this->profileLink      = SITE_URL . 'dungeon/' . $data['id'] . '/' . urlencode($data['name']);
        $this->firstGuildClear  = $data['first_guild_clear'];
        $this->recentGuildClear = $data['recent_guild_clear'];
    }
}