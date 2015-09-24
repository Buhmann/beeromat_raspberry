<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initDoctype() {
//        Zend_Loader::loadClass('Application_Plugin_Auth_AclList', '/');
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');

        $view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
        $view->jQuery()->addStylesheet('/js/jquery/css/ui-lightness/jquery-ui-1.10.3.custom.css')
                ->setLocalPath('/js/jquery/js/jquery-1.9.1.js')
                ->setUiLocalPath('/js/jquery/js/jquery-ui-1.10.3.custom.min.js');



        $view->jQuery()->enable();
        $view->jQuery()->uiEnable();
    }

}

