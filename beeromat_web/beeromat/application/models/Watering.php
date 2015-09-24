<?php

class Application_Model_Watering {

    protected $_wID;
    protected $_watering_time;
    protected $_timestamp;
    protected $_bm_temperature;
    protected $_bm_soil_mositure;
    protected $_count;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Ungültige Distraction Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Ungültige Distraction Eigenschaft');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getWID() {
        return $this->_wID;
    }

    public function setWID($_wID) {
        if ($_wID > 0) {
            $this->_wID = (int) $_wID;
        } else {
            $this->_wID = null;
        }
        return $this;
    }

    public function getWateringTime() {
        return $this->_watering_time;
    }

    public function setWateringTime($_watering_time) {
        $this->_watering_time = $_watering_time;
        return $this;
    }

    public function getTimestamp() {
        return $this->_timestamp;
    }

    public function setTimestamp($_timestamp) {
        $this->_timestamp = $_timestamp;
        return $this;
    }

    public function getBmTemperature() {
        return $this->_bm_temperature;
    }

    public function setBmTemperature($_bm_temperature) {
        $this->_bm_temperature = $_bm_temperature;
        return $this;
    }

    public function getBmSoilMositure() {
        return $this->_bm_soil_mositure;
    }

    public function setBmSoilMositure($_bm_soil_mositure) {
        $this->_bm_soil_mositure = $_bm_soil_mositure;
        return $this;
    }

    public function getCount() {
        return $this->_count;
    }

    public function setCount($_count) {
        $this->_count = $_count;
        return $this;
    }

}

