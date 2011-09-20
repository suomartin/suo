<?php

namespace Services;

use Domain\Atm;

class AtmService
{
    public function addTicket($s_atm_net_address, $n_room_id, $s_start_date)
    {
        /** @var Domain\AtmRepository */
        $o_atm_repository = \ServiceLocator::getRepository('Atm');

        $o_atm_repository->findByNetAddress($s_atm_net_address);

        $o_ticket_service = \ServiceLocator::getTicketService();
        $o_ticket_service->addTicket($n_room_id, $s_start_date);
    }
}
