<?php

class Application_Model_TemperatureMapper {

    protected $_dbTable = null;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Temperature Ungültiges Table Data Gateway angegeben');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Temperature');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Temperature $temperature) {
        $data = array(
            'tID' => $temperature->getTID(),
            'termperature' => $temperature->getTemperature(),
            'humidity' => $temperature->getHumidity(),
            'timestamp' => $temperature->getTimestamp(),
        );

        if (null === ($id = $temperature->getTID())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('tID = ?' => $id));
        }
    }

    public function find($id, Application_Model_Temperature $temperature) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();

        $temperature->setTID($row->tID)
                ->setTemperature($row->temperature)
                ->setHumidity($row->humidity)
                ->setTimestamp($row->timestamp);
    }

    public function fetchAll($from, $to) {
        $select = null;

        if ($from != null) {
            $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);

            if ($to == null)
                $to = $from;

            $select->where('DATE(timestamp) <= ?', $to)
                    ->where('DATE(timestamp) >= ?', $from)
                    ->order('timestamp DESC');
        }

        $resultSet = $this->getDbTable()->fetchAll($select);

        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Temperature();
            $entry->setTID($row->tID)
                    ->setTemperature($row->temperature)
                    ->setHumidity($row->humidity)
                    ->setTimestamp($row->timestamp);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchLatest($limit) {
        $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                ->order('timestamp DESC')
                ->limit($limit);

        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Temperature();
            $entry->setTID($row->tID)
                    ->setTemperature($row->temperature)
                    ->setHumidity($row->humidity)
                    ->setTimestamp($row->timestamp);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id) {
        $distractionRowset = $this->getDbTable()->find($id);
        $distraction = $distractionRowset->current();
        $anzDeletedRows = $distraction->delete();
        return $anzDeletedRows;
    }

}
