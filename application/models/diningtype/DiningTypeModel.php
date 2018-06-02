<?php

/**
 * dining type model
 */
class DiningTypeModel extends AbstractModel {
    const MODEL_NAME = 'Dining Type';

    public function __construct($dbh, $params) {
        parent::__construct($dbh);
    }

    public function getDiningTypes() {
        $diningTypes = array();

        try {
            $query = $this->_getDiningTypesFromDb();

            while ( $row = $query->fetch(PDO::FETCH_ASSOC) ) {
                array_push($diningTypes, $row);
            }
        } catch ( Exception $exception ) {
            logger('EROR', __FUNCTION__ . ' - ' . $exception->getMessage(), 'user');
        }

        return $diningTypes;
    }

    private function _getDiningTypesFromDb() {
        $query = sprintf(
            "SELECT
                Dining_types.id AS id,
                Dining_types.name AS name
            FROM
                Dining_types
            ORDER BY
                Dining_types.name ASC"
        );
        $query = $this->_dbh->prepare($query);

        $query->execute();

        return $query;
    }
}