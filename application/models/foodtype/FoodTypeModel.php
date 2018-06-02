<?php

/**
 * food type model
 */
class FoodTypeModel extends AbstractModel {
    const MODEL_NAME = 'Food Type';

    public function __construct($dbh, $params) {
        parent::__construct($dbh);
    }

    public function getFoodTypes() {
        $foodTypes = array();

        try {
            $query = $this->_getFoodTypesFromDb();

            while ( $row = $query->fetch(PDO::FETCH_ASSOC) ) {
                array_push($foodTypes, $row);
            }
        } catch ( Exception $exception ) {
            logger('EROR', __FUNCTION__ . ' - ' . $exception->getMessage(), 'user');
        }

        return $foodTypes;
    }

    private function _getFoodTypesFromDb() {
        $query = sprintf(
            "SELECT
                Food_Types.id AS id,
                Food_Types.name AS name
            FROM
                Food_Types
            ORDER BY
                Food_Types.name ASC"
        );
        $query = $this->_dbh->prepare($query);

        $query->execute();

        return $query;
    }
}