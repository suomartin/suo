<?php

namespace Domain;

class AtmRepository extends \Doctrine\ORM\EntityRepository
{
    public function findRoomsByNetAddress($s_net_address)
    {
        $o_atm = $this->findOneBy(array('netaddress' => $s_net_address));

        if (!$o_atm) {
            throw new \DomainException('No Atm with address ' . $s_net_address);
        }

        $a_rooms = $o_atm->getRooms();

        if (0 == count($a_rooms)) {
            throw new \DomainException('No Rooms to Atm with address ' . $s_net_address);
        }

        return $a_rooms;
    }
}