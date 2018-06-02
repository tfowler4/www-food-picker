<?php

/**
 * services controller
 */
class Services extends AbstractController {
    const CONTROLLER_NAME = 'Services';

    public function __construct($params) {
        parent::__construct();
        $this->_setParameters($params);
    }

    public function addRestaurant() {
        $restaurantModel = $this->_loadModel('restaurant');

        echo json_encode($restaurantModel->addRestaurant());
    }

    public function saveRestaurant() {
        $restaurantModel = $this->_loadModel('restaurant');

        echo json_encode($restaurantModel->saveRestaurant());
    }

    public function getRandomRestaurant() {
        $restaurantModel = $this->_loadModel('restaurant');

        $restaurants = $restaurantModel->getRestaurants();

        $topRestaurants  = array();
        $restaurantOrder = array();
        $sortedOrder     = array();

        for ( $i = 0; $i < 100000; $i++ ) {
            $random       = rand(0,count($restaurants)-1);
            $restaurant   = $restaurants[$random];
            $restaurantId = $restaurant['id'];
            
            if ( empty($topRestaurants[$restaurantId]) ) {
                $topRestaurants[$restaurantId] = $restaurant;
                $topRestaurants[$restaurantId]['count'] = 0;
            }

            $topRestaurants[$restaurantId]['count']++;
        }

        foreach ( $topRestaurants as $restaurant )  {
            $count = $restaurant['count'];

            $restaurantOrder[$count] = $restaurant;
        }

        krsort($restaurantOrder, SORT_NATURAL);

        foreach ( $restaurantOrder as $restaurant )  {
            $sortedOrder[] = $restaurant;
        }

        echo json_encode($sortedOrder);
    }

    public function getRestaurantById() {
        $id = $this->_params[1];

        $restaurantModel = $this->_loadModel('restaurant');

        $restaurant = $restaurantModel->getRestaurantById($id);

        echo json_encode($restaurant);
    }

    public function getRandomRestaurantWithFilters() {
        $restaurantModel = $this->_loadModel('restaurant');

        $restaurants = $restaurantModel->getRestaurantsWithFilters();
        
        if ( empty($restaurants) ) {
            echo json_encode(array());
            exit;
        }

        $random = rand(0,count($restaurants)-1);

        echo json_encode($restaurants[$random]);
    }
}