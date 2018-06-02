<?php

/**
 * encounter standings profile object
 */
class EncounterStandingsProfile {
    public $id;
    public $guildId;
    public $name;
    public $active;
    public $country;
    public $server;
    public $regionAbbreviation;
    public $abbreviation;
    public $worldRank;
    public $regionRank;
    public $serverRank;
    public $timeDifference;
    public $hasVideo = 0;
    public $videoLink;
    public $hasScreenshot  = 0;
    public $screenshotLink;
    public $dungeon;
    public $encounter;
    public $encounterId;
    public $submissionDate;
    public $profileLink;

    public function __construct($data) {
        $this->id                 = $data['id'];
        $this->guildId            = $data['guild_id'];
        $this->name               = $data['guild_name'];
        $this->country            = strtolower($data['country']);
        $this->server             = $data['server'];
        $this->active             = $data['active'];
        $this->region             = $data['region'];
        $this->regionAbbreviation = $data['region_abbreviation'];
        $this->dungeon            = $data['dungeon_name'];
        $this->encounter          = $data['encounter_name'];
        $this->encounterId        = $data['encounter_id'];
        $this->worldRank          = $data['world_rank'];
        $this->regionRank         = $data['region_rank'];
        $this->serverRank         = $data['server_rank'];
        $this->timeDifference     = '---';
        $this->hasScreenshot      = $data['has_screenshot'];
        $this->hasVideo           = $data['has_videos'];
        $this->submissionDate     = date("m/d/Y h:i", strtotime($data['date_submission']));
        $this->profileLink        = SITE_URL . 'guild/profile/' . $data['guild_id'] . '/' . urlencode($data['guild_name']);

        $this->_setAbbreviation();

        if ( $this->hasScreenshot == 1 ) {
            $this->screenshotLink = '<a href="http://www.pantheonmmo.com/images/screenshots/170925/170925_02_1080p.jpg" data-guild-id="' . $this->guildId . '" data-lightbox="' . $this->encounterId . '"><i class="fa fa-picture-o fa-fw fa-lg text-primary"></i></a>';
        } else {
            $this->screenshotLink = '<i class="fa fa-times fa-fw fa-lg text-danger"></i>';
        }

        if ( $this->hasVideo == 1 ) {
            $this->videoLink = '<a href="#" class="video-modal-btn" data-guild-id="' . $this->guildId . '" data-encounter-id="' . $this->encounterId . '"><i class="fa fa-youtube-play fa-fw fa-lg text-primary"></i></a>';
        } else {
            $this->videoLink = '<i class="fa fa-times fa-fw fa-lg text-danger"></i>';
        }
    }

    private function _setAbbreviation() {
        $wordsInName = explode(' ', $this->guild);

        if ( count($wordsInName) == 1 ) {
            $this->abbreviation = substr($wordsInName[0], 0, 1);
        } else {
            if ( $wordsInName[0] == 'The' ) {
                array_shift($wordsInName);
            }

            for ( $i = 0; $i < count($wordsInName); $i++ ) {
                if ( $i > 1 ) {
                    break;
                }

                $this->abbreviation .= substr($wordsInName[$i], 0, 1);
            }
        }
    }
}