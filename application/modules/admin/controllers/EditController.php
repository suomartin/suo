<?php

class Admin_EditController extends \Zend_Controller_Action
{
    public function atmAction()
    {
        $o_form = new Admin_Form_Edit();

        $o_atm = new Domain\Atm('', '');

        $o_form->createFormToEntity('Domain\Atm', $o_atm);

        $this->view->o_form = $o_form;
    }
}
