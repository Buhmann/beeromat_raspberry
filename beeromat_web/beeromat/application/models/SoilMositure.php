<?php

class Application_Model_SoilMositure {

    protected $_smID;
    protected $_mositure;
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

    public function getSmID() {
        return $this->_smID;
    }

    public function setSmID($_smID) {
        if ($_smID > 0) {
            $this->_smID = (int) $_smID;
        } else {
            $this->_smID = null;
        }
        return $this;
    }

    public function getMositure() {
        return $this->_mositure;
    }

    public function setMositure($_mositure) {
        $this->_mositure = $_mositure;
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

