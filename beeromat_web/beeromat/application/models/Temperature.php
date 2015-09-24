<?php

class Application_Model_Temperature {

    protected $_tID;
    protected $_temperature;
    protected $_humidity;
    protected $_timestamp;

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

    public function getTID() {
        return $this->_tID;
    }

    public function setTID($_tID) {

        if ($_tID > 0) {
            $this->_tID = (int) $_tID;
        } else {
            $this->_tID = null;
        }
        return $this;
    }

    public function getTemperature() {
        return $this->_temperature;
    }

    public function setTemperature($_temperature) {
        $this->_temperature = $_temperature;
        return $this;
    }

    public function getHumidity() {
        return $this->_humidity;
    }

    public function setHumidity($_humidity) {
        $this->_humidity = $_humidity;
        return $this;
    }

    public function getTimestamp() {
        return $this->_timestamp;
    }

    public function setTimestamp($_timestamp) {
        $this->_timestamp = $_timestamp;
        return $this;
    }

    public function getArray() {
        return array($this->getSmID(), $this->getMositure(), $this->getTimestamp());
    }

    public function getKeyValueArray() {
//        return array('distractionID' => $this->getId(), 'text' => $this->getText(), 'emotion_text' => $this->getEmotionText(), 'emotionID_fk' => $this->getEmotion());
    }

}

