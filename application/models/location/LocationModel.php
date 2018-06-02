<?php

/**
 * location model
 */
class LocationModel extends AbstractModel {
    const MODEL_NAME = 'Location';

    public function __construct($dbh, $params) {
        parent::__construct($dbh);
    }

    public function getLocations() {
        $locations = array();

        try {
            $query = $this->_getLocationsFromDb();

            while ( $row = $query->fetch(PDO::FETCH_ASSOC) ) {
                array_push($locations, $row);
            }
        } catch ( Exception $exception ) {
            logger('EROR', __FUNCTION__ . ' - ' . $exception->getMessage(), 'user');
        }

        return $locations;
    }

    private function _getLocationsFromDb() {
        $query = sprintf(
            "SELECT
                Locations.id AS id,
                Locations.name AS name
            FROM
                Locations
            ORDER BY
                Locations.name ASC"
        );
        $query = $this->_dbh->prepare($query);

        $query->execute();

        return $query;
    }
}