<?php

class Application_Model_DbTable_Watering extends Zend_Db_Table_Abstract {

    protected $_name = 'bm_watering';
    protected $_primary = 'wID';
    // Automatisch hochzaehlender PK
    protected $_sequence = true;
    
    protected $_referenceMap = array(
        'SoilMositure' => array(
            'columns' => 'fk_smID',
            'refTableClass' => 'Application_Model_DbTable_SoilMositure',
            'refColumns' => 'smID'
        ), 
        'Temperature' => array(
            'columns' => 'fk_tID',
            'refTableClass' => 'Application_Model_DbTable_Temperature',
            'refColumns' => 'tID'
        )
    );

}

