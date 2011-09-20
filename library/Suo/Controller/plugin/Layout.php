<?php

class Suo_Controller_Plugin_Layout extends Zend_Controller_Plugin_Abstract
{
   public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
   {
        $layout = Zend_Layout::getMvcInstance();
        // указываем путь к layout'ам
        $module = $request->getModuleName();
        if ('default' != $module) {
            $layout->setLayoutPath(APPLICATION_PATH . '/modules/' . $request->getModuleName() . '/layouts/scripts');
        }
   }
}