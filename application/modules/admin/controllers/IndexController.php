<?php

class Admin_IndexController extends \Zend_Controller_Action
{
    public function indexAction()
    {
        $o_em = ServiceLocator::getEm();

        echo nl2br(var_export($o_em->getClassMetadata('Domain\Atm'), true));
    }
}
