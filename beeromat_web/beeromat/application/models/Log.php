<?php

class Application_Model_Log {

    protected $_lID;
    protected $_message;
    protected $_timestamp;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Ungültige Log Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Ungültige Log Eigenschaft');
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

    public function getLID() {
        return $this->_lID;
    }

    public function setLID($_lID) {
        if ($_lID > 0) {
            $this->_lID = (int) $_lID;
        } else {
            $this->_lID = null;
        }
        return $this;
    }

    public function getMessage() {
        return $this->_message;
    }

    public function setMessage($_message) {
        $this->_message = $_message;
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

