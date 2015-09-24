<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function getWateringData($from, $to) {
        $wateringMapper = new Application_Model_WateringMapper();
        $waterings = $wateringMapper->fetchLatest($from, $to);

        $json = array();
        foreach ($waterings as $wa) {
            $data = array(strtotime($wa->getTimestamp()) * 1000, $wa->getCount());
            $json[] = $data;
        }
        return ($json);
    }

    public function getTemperature($from, $to = null) {
        /* Temperatur und Luftfeuchtigkeit */
        $temperatureMapper = new Application_Model_TemperatureMapper();
        $temperatures = $temperatureMapper->fetchAll($from, $to);
        $temperature = array();
        $humidity = array();

        foreach ($temperatures as $tp) {
            $data = array(strtotime($tp->getTimestamp()) * 1000, $tp->getTemperature());
            $temperature[] = $data;
            $data = array(strtotime($tp->getTimestamp()) * 1000, $tp->getHumidity());
            $humidity[] = $data;
        }

        return array('temperature' => $temperature, 'humidity' => $humidity);
    }

    public function getSoilMositure($from, $to = null) {


        $soilMositureMapper = new Application_Model_SoilMositureMapper();
        $soilMositures = $soilMositureMapper->fetchAll($from, $to);
        $json = array();
        foreach ($soilMositures as $sm) {
            $data = array(strtotime($sm->getTimestamp()) * 1000, $sm->getMositure());
            $json[] = $data;
        }
        return $json;
    }

    public function indexAction() {

        $this->view->jQuery()->addJavascriptFile('/js/flot/js/jquery.flot.min.js')
                ->addJavascriptFile('/js/flot/js/jquery.flot.time.min.js')
                ->addJavascriptFile('/js/jquery/js/jquery.dataTables.min.js')
                ->addJavascriptFile('/js/jquery/js/dataTables.date-de.js')
                ->addJavascriptFile('/js/charts/charts.js')
                ->addStylesheet('/js/flot/css/example.css')
                ->addStylesheet('/js/jquery/css/jquery.dataTables.css');





        /* Bodefeuchtigkeit */
//        $timestamp = time();
//        $today = date("Y-m-d", $timestamp);
//        $bis = date("Y-m-d", strtotime("-7 day"));
//
//        $logMapper = new Application_Model_LogMapper();
//
//        $this->view->logs = $logMapper->fetchAll();
//
//        $this->view->watering = Zend_Json::encode($this->getWateringData($bis, $today));
//        $this->view->soilMositure = Zend_Json::encode($this->getSoilMositure($today));
//
//        $soilMositureMapper = new Application_Model_SoilMositureMapper();
//        $soilMositure = $soilMositureMapper->fetchLatest(1);
////        var_dump($soilMositure);
////        die();
//        $this->view->latestSoilMositure = $soilMositure[0];
//
//        $temp_humidity = $this->getTemperature($today);
//        $this->view->temperature = Zend_Json::encode($temp_humidity['temperature']);
//        $this->view->humidity = Zend_Json::encode($temp_humidity['humidity']);
//
//        $temperatureMapper = new Application_Model_TemperatureMapper();
//        $latestTemperature = $temperatureMapper->fetchLatest(1);
//        $this->view->latestTemperature = $latestTemperature[0];
    }

    public function getTemperatureAction() {
        $data = $this->getRequest()->getParam('data');
        $from = date("Y-m-d", strtotime($data[0]));
        $to = date("Y-m-d", strtotime($data[1]));

        if (empty($data[1]))
            $to = null;

        echo Zend_Json::encode($this->getTemperature($from, $to));
        exit();
    }

    public function getSoilMositureAction() {
        $data = $this->getRequest()->getParam('data');
        $from = date("Y-m-d", strtotime($data[0]));
        $to = date("Y-m-d", strtotime($data[1]));

        if (empty($data[1]))
            $to = null;



        echo Zend_Json::encode($this->getSoilMositure($from, $to));
        exit();
    }

    public function execWaterAction() {
        $duration = $this->getRequest()->getParam('data');
        $duration = 10;
        system("sudo python python/test.py");
//        echo exec("sudo python python/test.py");

        exit();
    }

}
