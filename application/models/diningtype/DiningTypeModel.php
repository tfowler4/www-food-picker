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
                Dining_Types.id AS id,
                Dining_Types.name AS name
            FROM
                Dining_Types
            ORDER BY
                Dining_Types.name ASC"
        );
        $query = $this->_dbh->prepare($query);

        $query->execute();

        return $query;
    }
}