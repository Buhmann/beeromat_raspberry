<?php

class Application_Model_DbTable_SoilMositure extends Zend_Db_Table_Abstract {

    protected $_name = 'bm_soil_mositure';
    protected $_primary = 'smID';
    // Automatisch hochzaehlender PK
    protected $_sequence = true;
    protected $_dependentTables = array('Application_Model_DbTable_Watering');
    
//    protected $_referenceMap = array(
//        'Watering' => array(
//            'columns' => 'smID',
//            'refTableClass' => 'Application_Model_DbTable_Watering',
//            'refColumns' => 'fk_smID'
//        )
//    );

}

