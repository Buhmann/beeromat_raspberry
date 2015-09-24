<?php

class Application_Model_WateringMapper {

    protected $_dbTable = null;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Watering: Ungültiges Table Data Gateway angegeben');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Watering');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Watering $watering) {
        $data = array(
            'wID' => $watering->getWID(),
            'watering_time' => $watering->getWateringTime(),
            'timestamp' => $watering->getTimestamp(),
            'fk_tID' => $watering->getBmTemperature()->getTID(),
            'timestamp' => $watering->getBmSoilMositure()->getSmID(),
        );

        if (null === ($id = $watering->getWID())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('wID = ?' => $id));
        }
    }

    public function find($id, Application_Model_Watering $watering) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();

        $temperature_row = $row->findParentRow('Application_Model_DbTable_Temperature');
        $temperature = new Application_Model_Temperature();
        $temperature->setTID($temperature_row->tID)
                ->setTemperature($temperature_row->temperature)
                ->setHumidity($temperature_row->humidity)
                ->setTimestamp($temperature_row->timestamp);
        $watering->setBmTemperature($temperature);


        $soilMositure_row = $row->findParentRow('Application_Model_DbTable_SoilMositure');

        $soilMositure = new Application_Model_SoilMositure();
        $soilMositure->setSmID($soilMositure_row->smID)
                ->setMositure($soilMositure_row->mositure)
                ->setTimestamp($soilMositure_row->timestamp);
        $watering->setBmSoilMositure($soilMositure);

        $watering->setWID($row->wID)
                ->setWateringTime($row->watering_time)
                ->setTimestamp($row->timestamp);
    }

    public function fetchAll() {

        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Watering();
            $entry->setWID($row->wID)
                    ->setWateringTime($row->watering_time)
                    ->setTimestamp($row->timestamp);


            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchLatest($from, $to) {
//        SELECT DATE(timestamp) as timestamp, count(*) as count FROM `bm_watering`
//where DATE(timestamp) > '2014-03-12' and DATE(timestamp) < '2014-03-14'
//group by DATE(timestamp)

        $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                ->columns(array('DATE(timestamp) as timestamp', 'count(*) as count'))
                ->where('DATE(timestamp) >= ?', $from)
                ->where('DATE(timestamp) <= ?', $to)
                ->group('DATE(timestamp)')
                ->order('timestamp ASC');

        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Watering();
            $entry->setCount($row->count)
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
