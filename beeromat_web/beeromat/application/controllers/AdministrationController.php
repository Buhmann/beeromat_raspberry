<?php

class AdministrationController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $this->view->jQuery()->addJavascriptFile('/js/admin/admin.js');
    }

    /*
     * Mapping Buttons
     * power up = 1
     * read soil mositure = 2
     * bucket = 3
     * temperature = 4
     */

    public function execAction() {
        $id = $this->getRequest()->getParam('data');
        switch ($id) {
            case 1:
                system("sudo python python/pumpe.py");
                break;
            case 2:
                system("sudo python python/soilMositure.py");
                break;
            case 3:
                system("sudo python python/sensor.py");
                break;
            case 4:
                system("sudo python/Adafruit_DHT 22 23");
                break;
        }

        exit();
    }

}

