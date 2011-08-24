<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoloader()
    {
        Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
    }
}

