<?php

class Atm_IndexController extends \Zend_Controller_Action
{
    public function indexAction()
    {
        $this->view->b_error = false;
        try {
            $o_atm_repo = \ServiceLocator::getRepository('Atm');
            $s_client_ip = $this->getRequest()->getClientIp();
            $this->view->a_rooms = $o_atm_repo->findRoomsByNetAddress($s_client_ip);
//            /** @var Domain\AtmService */
//            $o_atm_service = \ServiceLocator::getAtmService();
//            $s_net_address = $this->getRequest()->getClientIp();
//            $s_start_date = '2011-01-01';
//            $n_room_id = $this->getRequest()->getParam('room');
//            $o_atm_service->addTicket($s_net_address, $n_room_id, $s_start_date);
        } catch (\DomainException $e) {
            $this->view->b_error = true;
            $this->view->s_error_message = $e->getMessage();
        }
    }
}
