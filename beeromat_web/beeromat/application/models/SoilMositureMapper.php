<?php

class Application_Model_SoilMositureMapper {

    protected $_dbTable = null;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Ungültiges Table Data Gateway angegeben');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_SoilMositure');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_SoilMositure $soilMositure) {
        $data = array(
            'smID' => $soilMositure->getSmID(),
            'mositure' => $soilMositure->getMositure(),
            'timestamp' => $soilMositure->getTimestamp(),
        );

        if (null === ($id = $soilMositure->getSmID())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('smID = ?' => $id));
        }
    }

    public function find($id, Application_Model_SoilMositure $soilMositure) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();

        $soilMositure->setSmID($row->smID)
                ->setMositure($row->mositure)
                ->setTimestamp($row->timestamp);
    }

    public function fetchAll($from = null, $to = null) {
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
            $entry = new Application_Model_SoilMositure();
            $entry->setSmID($row->smID)
                    ->setMositure($row->mositure)
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
            $entry = new Application_Model_SoilMositure();
            $entry->setSmID($row->smID)
                    ->setMositure($row->mositure)
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
