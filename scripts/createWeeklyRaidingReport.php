<?php

if ( !defined('SITE_NAME') ) { die('Direct access not permitted'); }

/**
 * backup database maintenance script
 */
class WeeklyRaidingReport implements ScriptInterface {
    private $_response;

    private $_startDate;
    private $_endDate;
    private $_encounterKills;
    private $_dungeons;
    private $_content;
    private $_articleTitle;
    private $_dbh;

    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        logger(0, 'Starting Generate Weekly Raiding Report...', 'dev');

        $this->setResponse('warning', 'Generate Weekly Raiding Report had a Warning!');

        $this->checkVariables();

        $this->execute();

        $this->endScript();
    }

    /**
     * begin execution of the script
     *
     * @return void
     */
    public function execute() {
        $this->_getDateWeekRange();

        $this->_getEncounterKills();

        $this->_orderKillsByDungeon();

        $this->_orderKillsByEncounter();

        $this->_createArticle();

        $this->_addArticleToDb();

        $this->_createSocialMediaPosts();

        $this->setResponse('success', 'Create Weekly Raiding Report Completed!');

        $this->endScript();
    }

    private function _getDateWeekRange() {
        $endDateStrtotime   = strtotime('now');
        $endDate            = date('Y-m-d', $endDateStrtotime);
        $startDateStrtotime = strtotime('-7 days', $endDateStrtotime);
        $startDate          = date('Y-m-d', $startDateStrtotime);

        $this->_articleTitle = 'Raiding Report ' . $startDate . ' - ' . $endDate;
        $this->_startDate    = $startDate .' 00:00:00';
        $this->_endDate      = $endDate .' 00:00:00';
    }

    private function _orderKillsByDungeon() {
        $dungeons = array();

        foreach ( $this->_encounterKills as $encounter ) {
            $dungeonId   = $encounter['dungeon_id'];
            $dungeonName = $encounter['dungeon_name'];

            if ( empty($dungeons[$dungeonId]) ) {
                $dungeons[$dungeonId]          = array();
                $dungeons[$dungeonId]['kills'] = array();
                $dungeons[$dungeonId]['name']  = $dungeonName;
            }

            array_push($dungeons[$dungeonId]['kills'], $encounter);
        }

        $this->_dungeons = $dungeons;
    }

    private function _orderKillsByEncounter() {
        foreach ( $this->_dungeons as $index => $dungeon ) {
            $encounterKills = $dungeon['kills'];
            $encounters     = array();

            foreach ( $encounterKills as $encounterKill ) {
                $encounterId   = $encounterKill['encounter_id'];
                $encounterName = $encounterKill['encounter_name'];

                if ( empty($encounters[$encounterId]) ) {
                    $encounters[$encounterId]          = array();
                    $encounters[$encounterId]['kills'] = array();
                    $encounters[$encounterId]['name']  = $encounterName;
                }

                array_push($encounters[$encounterId]['kills'], $encounterKill);
            }

            $dungeon['encounters'] = $encounters;
            $this->_dungeons[$index] = $dungeon;
        }
    }

    private function _createArticle() {
        $html = '<ul class="list-unstyled">';

        foreach ( $this->_dungeons as $index => $dungeon ) {
            $dungeonName = $dungeon['name'];
            $encounters  = $dungeon['encounters'];

            $html .= '<li><h3 class="article">' . $dungeonName . '</h3></li>';

            foreach ( $encounters as $encounter ) {
                $encounterName  = $encounter['name'];
                $encounterKills = $encounter['kills'];

                $html .= '<li><h4>' . $encounterName . '</h4></li>';
                $html .= '<li><ul>';

                foreach ( $encounterKills as $encounterKill ) {
                    $html .= '<li>';
                        $html .= '<span class="flag-icon flag-icon-' . strtolower($encounterKill['server_country_abbreviation']) . '"></span>';
                        $html .= ' <span class="' . strtolower($encounterKill['faction']) . '">' . $encounterKill['name'] . '</span> @ ' . $encounterKill['datetime'];
                    $html .= '</li>';
                }

                $html .= '</ul></li>';
            }
        }

        $html .= '</ul>';

        echo $html;
        $this->_content = $html;
    }

    private function _getEncounterKills() {
        $this->_dbh = Database::getHandler();

        $encounterKillsModel   = new EncounterKillsModel($this->_dbh);
        $this->_encounterKills = $encounterKillsModel->getEncounterKillByDateRangeFromDb($this->_startDate, $this->_endDate);

        if ( count($this->_encounterKills) == 0 ) {
            $this->setResponse('warning', 'No encounter kills for the date range!');
            $this->endScript();
        }
    }

    private function _addArticleToDb() {
        $query = $this->_dbh->prepare(
            "INSERT INTO
                news_table (title, published, content, added_by)
             values
                (:title, 1, :content, 'News Bot')"
        );

        $query->bindParam(':title', $this->_articleTitle);
        $query->bindParam(':content', $this->_content);

        return $query->execute();
    }

    /**
     * post news article to twitter social network
     *
     * @param  string  $articleTitle [ title of news article ]
     * @param  integer $type         [ type of news article ]
     *
     * @return void
     */
    private function _postTwitter($articleTitle, $type) {
        // 0 - Standard News Article
        // 1 - Weekly Report

        include_once ABS_BASE_PATH . 'library/twitter/codebird-php-master/src/codebird.php';

        $statusUpdate   = '';
        $hyperlinkTitle = urlencode($articleTitle);
        $hyperlink      = SITE_URL . '/article/' . $this->_dbh->lastInsertId() . '/' . $hyperlinkTitle;
        $hyperlinkShort = getBitlyLink($hyperlink);

        \Codebird\Codebird::setConsumerKey(TWITTER_KEY, TWITTER_SECRET);
        $cb = \Codebird\Codebird::getInstance();
        $cb->setToken(TWITTER_TOKEN, TWITTER_TOKEN_SECRET);

        if ( $type == 0 ) {
            $statusUpdate = 'Latest Article: ' . $articleTitle . ' ' . $hyperlinkShort;
        } else if ( $type == 1 ) {
            $statusUpdate = 'Check out the latest kills in our weekly raiding report! ' . $hyperlinkShort;
        }

        $params = array(
          'status' => $statusUpdate . ' #' . GAME_NAME . ' #mmo #raiding'
        );

        $reply = $cb->statuses_update($params);
    }

    private function _createSocialMediaPosts() {

        $this->_postTwitter($this->_articleTitle, 1);
    }

    /**
     * check any parameters sent to configure the script execution
     *
     * @return void
     */
    public function checkVariables() {}

    /**
     * set the response the script will return if it were to end
     *
     * @param string $status  [ status of script if success, fail, or warning ]
     * @param string $message [ response message for the script ]
     *
     * @return void
     */
    public function setResponse($status, $message) {
        $this->_response['status']   = $status;
        $this->_response['response'] = $message;
    }

    /**
     * end the script and log any messages if needed
     *
     * @return void
     */
    public function endScript() {
        echo json_encode($this->_response);
        die();
    }
}

new WeeklyRaidingReport();