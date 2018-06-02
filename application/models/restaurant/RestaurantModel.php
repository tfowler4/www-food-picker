<?php

/**
 * restaurant model
 */
class RestaurantModel extends AbstractModel {
    const MODEL_NAME = 'Restaurant';

    public function __construct($dbh, $params) {
        parent::__construct($dbh);
    }

    public function getRestaurants() {
        $restaurants = array();
        
        try {
            $query = $this->_getRestaurantsFromDb();

            while ( $row = $query->fetch(PDO::FETCH_ASSOC) ) {
                array_push($restaurants, $row);
            }
        } catch ( Exception $exception ) {
            logger('EROR', __FUNCTION__ . ' - ' . $exception->getMessage(), 'user');
        }

        return $restaurants;
    }

    private function _getRestaurantsFromDb() {
        $query = sprintf(
            "SELECT
                Restaurants.id AS id,
                Restaurants.name AS name,
                Locations.name AS location,
                Food_Types.name AS food_type,
                Dining_Types.name AS dining_type,
                Meals.name AS meal
            FROM
                Restaurants
            LEFT JOIN
                Locations
            ON
                Restaurants.location = Locations.id
            LEFT JOIN
                Food_Types
            ON
                Restaurants.food_type = Food_Types.id
            LEFT JOIN
                Dining_Types
            ON
                Restaurants.dining_type = Dining_Types.id
            LEFT JOIN
                Meals
            ON
                Restaurants.meal = Meals.id
            ORDER BY
                Restaurants.name ASC"
        );

        $query = $this->_dbh->prepare($query);

        $query->execute();

        return $query;
    }

    public function getRestaurantById($id) {
        $restaurant = array();
        
        try {
            $query = $this->_getRestaurantByIdFromDb($id);

            $restaurant = $query->fetch(PDO::FETCH_ASSOC);
        } catch ( Exception $exception ) {
            logger('EROR', __FUNCTION__ . ' - ' . $exception->getMessage(), 'user');
        }

        return $restaurant;
    }

    private function _getRestaurantByIdFromDb($id) {
        $query = sprintf(
            "SELECT
                Restaurants.id AS id,
                Restaurants.name AS name,
                Locations.name AS location,
                Food_Types.name AS food_type,
                Dining_Types.name AS dining_type,
                Meals.name AS meal,
                Locations.id AS location_id,
                Food_Types.id AS food_type_id,
                Dining_Types.id AS dining_type_id,
                Meals.id AS meal_id
            FROM
                Restaurants
            LEFT JOIN
                Locations
            ON
                Restaurants.location = Locations.id
            LEFT JOIN
                Food_Types
            ON
                Restaurants.food_type = Food_Types.id
            LEFT JOIN
                Dining_Types
            ON
                Restaurants.dining_type = Dining_Types.id
            LEFT JOIN
                Meals
            ON
                Restaurants.meal = Meals.id
            WHERE
                Restaurants.id = :id
            ORDER BY
                Restaurants.name ASC"
        );

        $query = $this->_dbh->prepare($query);

        $query->bindParam(':id', $id);

        $query->execute();

        return $query;
    }

    public function getRestaurantsWithFilters() {
        $restaurants = array();

        try {
            $query = $this->_getRestaurantsWithFiltersFromDb();

            while ( $row = $query->fetch(PDO::FETCH_ASSOC) ) {
                array_push($restaurants, $row);
            }
        } catch ( Exception $exception ) {
            logger('EROR', __FUNCTION__ . ' - ' . $exception->getMessage(), 'user');
        }

        return $restaurants;        
    }

    private function _getRestaurantsWithFiltersFromDb() {
        $foodType   = Post::get('food-type');
        $location   = Post::get('location');
        $diningType = Post::get('dining-type');
        $meal       = Post::get('meal');

        $whereStarted   = FALSE;
        $whereStatement = 'WHERE';

        if ( !empty($foodType) ) {
            $whereStatement .= ' Restaurants.food_type = ' . $foodType;

            $whereStarted = TRUE;
        }

        if ( !empty($location) ) {
            if ( $whereStarted == TRUE ) { $whereStatement .= ' AND '; }

            $whereStatement .= 'Restaurants.location = ' . $location;

            $whereStarted = TRUE;
        }

        if ( !empty($diningType) ) {
            if ( $whereStarted == TRUE ) { $whereStatement .= ' AND '; }

            $whereStatement .= 'Restaurants.dining_type = ' . $diningType;

            $whereStarted = TRUE;
        }

        if ( !empty($meal) ) {
            if ( $whereStarted == TRUE ) { $whereStatement .= ' AND '; }

            $whereStatement .= 'Restaurants.meal = ' . $meal;

            $whereStarted = TRUE;
        }

        $query = sprintf(
            "SELECT
                Restaurants.id AS id,
                Restaurants.name AS name,
                Locations.name AS location,
                Food_Types.name AS food_type,
                Dining_Types.name AS dining_type,
                Meals.name AS meal
            FROM
                Restaurants
            LEFT JOIN
                Locations
            ON
                Restaurants.location = Locations.id
            LEFT JOIN
                Food_Types
            ON
                Restaurants.food_type = Food_Types.id
            LEFT JOIN
                Dining_Types
            ON
                Restaurants.dining_type = Dining_Types.id
            LEFT JOIN
                Meals
            ON
                Restaurants.meal = Meals.id"
        );
            
        if ( $whereStarted == TRUE ) {
            $query .= ' ' . $whereStatement;
        }

        $query .= sprintf(
            " ORDER BY
                Restaurants.name ASC");

        $query = $this->_dbh->prepare($query);

        $query->execute();

        return $query;        
    }

    public function addRestaurant() {
        $isRestaurantAdded = TRUE;

        try {
            $isRestaurantAdded = $this->_addRestaurantToDb();
        } catch ( Exception $exception ) {
            logger('EROR', __FUNCTION__ . ' - ' . $exception->getMessage(), 'user');
        }

        return $isGuildCreated;
    }

    private function _addRestaurantToDb() {
        $name       = Post::get('name');
        $foodType   = Post::get('food-type');
        $location   = Post::get('location');
        $diningType = Post::get('dining-type');
        $meal       = Post::get('meal');

        $query = sprintf(
            "INSERT INTO
                restaurants (name, location, food_type, dining_type, meal)
            values
                (:name, :location, :foodType, :diningType, :meal)"
        );

        $query = $this->_dbh->prepare($query);

        $query->bindParam(':name', $name);
        $query->bindParam(':location', $location);
        $query->bindParam(':foodType', $foodType);
        $query->bindParam(':diningType', $diningType);
        $query->bindParam(':meal', $meal);

        return $query->execute();
    }

    public function saveRestaurant() {
        $isRestaurantSaved = FALSE;

        try {
            $isRestaurantSaved = $this->_saveRestaurantToDb();
        } catch ( Exception $exception ) {
            logger('EROR', __FUNCTION__ . ' - ' . $exception->getMessage(), 'user');
        }

        return $isRestaurantSaved;
    }

    private function _saveRestaurantToDb() {
        $id         = Post::get('id');
        $name       = Post::get('name');
        $foodType   = Post::get('food-type');
        $location   = Post::get('location');
        $diningType = Post::get('dining-type');
        $meal       = Post::get('meal');

        $query = sprintf(
            "UPDATE
                restaurants
            SET
                name = :name,
                location = :location,
                food_type = :foodType,
                dining_type = :diningType,
                meal = :meal
            WHERE
                id = :id"
        );

        $query = $this->_dbh->prepare($query);

        $query->bindParam(':id', $id);
        $query->bindParam(':name', $name);
        $query->bindParam(':location', $location);
        $query->bindParam(':foodType', $foodType);
        $query->bindParam(':diningType', $diningType);
        $query->bindParam(':meal', $meal);

        return $query->execute();
    }
}