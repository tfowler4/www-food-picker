<?php

/**
 * meal type model
 */
class MealModel extends AbstractModel {
    const MODEL_NAME = 'Meal';

    public function __construct($dbh, $params) {
        parent::__construct($dbh);
    }

    public function getMeals() {
        $meals = array();

        try {
            $query = $this->_getMealsFromDb();

            while ( $row = $query->fetch(PDO::FETCH_ASSOC) ) {
                array_push($meals, $row);
            }
        } catch ( Exception $exception ) {
            logger('EROR', __FUNCTION__ . ' - ' . $exception->getMessage(), 'user');
        }

        return $meals;
    }

    private function _getMealsFromDb() {
        $query = sprintf(
            "SELECT
                Meals.id AS id,
                Meals.name AS name
            FROM
                Meals
            ORDER BY
                Meals.name ASC"
        );
        $query = $this->_dbh->prepare($query);

        $query->execute();

        return $query;
    }
}