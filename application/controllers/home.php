<?php

/**
 * home controller
 */
class Home extends AbstractController {
    const CONTROLLER_NAME  = 'Home';
    const PAGE_TITLE       = 'Home';
    const PAGE_DESCRIPTION = 'Home Description';

    public function __construct($params) {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setPageDescription(META_DESCRIPTION);
        $this->_setParameters($params);
    }

    public function index() {
        $restaurantModel  = $this->_loadModel('restaurant');
        $locationModel    = $this->_loadModel('location');
        $foodTypesModel   = $this->_loadModel('foodtype');
        $diningTypesModel = $this->_loadModel('diningtype');
        $mealsModel       = $this->_loadModel('meal');
        
        $this->_data['restaurants'] = $restaurantModel->getRestaurants();
        $this->_data['locations']   = $locationModel->getLocations();
        $this->_data['foodTypes']   = $foodTypesModel->getFoodTypes();
        $this->_data['diningTypes'] = $diningTypesModel->getDiningTypes();
        $this->_data['meals']       = $mealsModel->getMeals();

        $this->_loadPageView('home/index', $this->_data);
    }
}