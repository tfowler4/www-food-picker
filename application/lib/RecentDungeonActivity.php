<?php

/**
 * recent dungeon activity object
 */
class RecentDungeonActivity {
    public $id;
    public $guildId;
    public $guild;
    public $abbreviation;
    public $encounter;
    public $encounterId;
    public $submissionDate;
    public $profileLink;

    public function __construct($data) {
        $this->id             = $data['id'];
        $this->guildId        = $data['guild_id'];
        $this->guild          = $data['guild_name'];
        $this->encounter      = $data['encounter_name'];
        $this->encounterId    = $data['encounter_id'];
        $this->submissionDate = date("m/d/Y", strtotime($data['date_submission']));
        $this->profileLink    = SITE_URL . 'guild/profile/' . $data['guild_id'] . '/' . urlencode($data['guild_name']);

        $this->_setAbbreviation();
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
