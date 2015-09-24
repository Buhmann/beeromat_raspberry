<?php

class Application_Model_Bucket {

    protected $_bID;
    protected $_timestamp;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Ungültige Bucket Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Ungültige Bucket Eigenschaft');
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

    public function getBID() {
        return $this->_bID;
    }

    public function setBID($_lID) {
        if ($_lID > 0) {
            $this->_bID = (int) $_lID;
        } else {
            $this->_bID = null;
        }
        return $this;
    }

    public function getTimestamp() {
        return $this->_timestamp;
    }

    public function setTimestamp($_timestamp) {
        $this->_timestamp = $_timestamp;
        return $this;
    }

}

