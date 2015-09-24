<?php

class Application_Model_Status {

    protected $_sID;
    protected $_status;

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

    public function getSID() {
        return $this->_sID;
    }

    public function setSID($_lID) {
        if ($_lID > 0) {
            $this->_sID = (int) $_lID;
        } else {
            $this->_sID = null;
        }
        return $this;
    }

    public function getMessage() {
        return $this->_status;
    }

    public function setMessage($_message) {
        $this->_status = $_message;
        return $this;
    }

}

