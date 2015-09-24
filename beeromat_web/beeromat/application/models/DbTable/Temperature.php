<?php

class Application_Model_DbTable_Temperature extends Zend_Db_Table_Abstract {

    protected $_name = 'bm_temperature';
    protected $_primary = 'tID';
    // Automatisch hochzaehlender PK
    protected $_sequence = true;
    protected $_dependentTables = array('Watering');
//
//    protected $_referenceMap = array(
//        'Watering' => array(
//            'columns' => 'tID',
//            'refTableClass' => 'Application_Model_DbTable_Watering',
//            'refColumns' => 'fk_tID'
//        )
//    );

}

