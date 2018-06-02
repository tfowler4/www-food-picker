<?php

/**
 * encounter profile object
 */
class EncounterProfile {
    public $id;
    public $name;
    public $dungeonId;
    public $dungeon;
    public $tier;
    public $raidSize;
    public $numOfCompletions;
    public $dateAvailable;
    public $firstGuildClear;
    public $recentGuildClear;
    public $profileLink;
    public $standingsLink;

    public function __construct($data) {
        $this->id               = $data['id'];
        $this->name             = $data['name'];
        $this->dungeonId        = $data['dungeon_id'];
        $this->dungeon          = $data['dungeon'];
        $this->tier             = $data['tier'];
        $this->raidSize         = $data['raid_size'];
        $this->numOfCompletions = $data['num_of_completions'];
        $this->dateAvailable    = date("m/d/Y", strtotime($data['date_available']));
        $this->firstGuildClear  = $data['first_guild_clear'];
        $this->recentGuildClear = $data['recent_guild_clear'];
        $this->standingsLink    = SITE_URL . 'standings/encounter/' . $data['id'] . '/' . urlencode($data['name']);
        $this->profileLink      = SITE_URL . 'encounter/' . $data['id'] . '/' . urlencode($data['name']);
    }
}