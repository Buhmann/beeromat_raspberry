<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogMappe
 *
 * @author dominic
 */
class Application_Model_LogMapper {

    protected $_dbTable = null;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Log: Ungültiges Table Data Gateway angegeben');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Log');
        }
        return $this->_dbTable;
    }

    public function fetchAll() {        
        $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->order('timestamp DESC');
        $select->limit(30);       
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Log();
            $entry->setLID($row->lID)
                    ->setMessage($row->message)
                    ->setTimestamp(date('d.m.Y H:i',strtotime($row->timestamp)));
            $entries[] = $entry;
        }
        return $entries;
    }

}



?>
