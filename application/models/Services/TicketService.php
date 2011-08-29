<?php

namespace Services;

use Domain\Ticket,
    Domain\Room,
    Domain\Coupon;

class TicketService
{
    public function addTicket($n_room_id, $s_start_datetime)
    {
        $o_room_repository = \ServiceLocator::getRepository('Room');

        $o_room = $o_room_repository->find($n_room_id);

        if (null == $o_room) {
            throw new \DomainException('Room is not found');
        }

        $o_start_datetime = null;
        try {
            $o_start_datetime = new \DateTime($s_start_datetime);
        } catch (\Exception $e) {
            throw new \DomainException('Start date is not correct');
        }
        $n_coupon_number = $this->getMaxCouponNumberByDate($o_start_datetime);
        ++$n_coupon_number;
        $o_coupon = new Coupon($o_start_datetime, $n_coupon_number);

        $o_ticket = new Ticket($o_room, $o_coupon, $o_start_datetime);

        $o_em = \ServiceLocator::getEm();

        $o_em->transactional(function($o_em) use ($o_ticket) {
            $o_em->persist($o_ticket);
            $o_em->flush();
        });

        return $o_ticket;
    }

    protected function getMaxCouponNumberByDate(\DateTime $o_date)
    {
        $n_max_number = 0;

        $a_max_number = \ServiceLocator::getRepository('Coupon')
                ->findBy(array('start_date' => $o_date), array('number' => 'ASC'), 1, 0);

        if (count($a_max_number) > 0) {
            $n_max_number = $a_max_number[0]->getNumber();
        }

        return $n_max_number;
    }
}
