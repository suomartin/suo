<?php

namespace Services;

use Domain\Ticket,
    Domain\Room;

class TicketService
{
    public function addTicket($n_room_id)
    {
        $o_room_repository = \ServiceLocator::getRoomRepository();

        $o_room = $o_room_repository->find($n_room_id);

        if (null == $o_room) {
            throw new \DomainException('Room is not found');
        }
    }
}
