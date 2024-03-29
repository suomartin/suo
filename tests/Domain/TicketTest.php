<?php

namespace Test\Domain;

use Domain\Ticket,
    Domain\Room;

/**
 * Test class for Ticket.
 * Generated by PHPUnit on 2011-08-23 at 22:06:48.
 */
class TicketTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Room object to use with Ticket
     *
     * @return \Domain\Room
     */
    protected function getRoom()
    {
        $o_room = $this->getMock('Domain\Room', array(), array(), '', false);

        return $o_room;
    }

    protected function getCoupon()
    {
        $o_coupon = $this->getMock('Domain\Coupon', array(), array(), '', false);

        return $o_coupon;
    }

    public function testHasId()
    {
        $o_room = $this->getRoom();
        $o_coupon = $this->getCoupon();

        $o_ticket = new Ticket($o_room, $o_coupon, new \DateTime('now'));

        $this->assertAttributeEmpty('id', $o_ticket);
    }

    public function testHasCreationTime()
    {
        $o_room = $this->getRoom();
        $o_coupon = $this->getCoupon();

        $o_ticket = new Ticket($o_room, $o_coupon, new \DateTime('now'));

        $this->assertAttributeEquals(new \DateTime('now'), 'creation_time', $o_ticket);
    }

    public function testHasStartTime()
    {
        $o_room = $this->getRoom();
        $o_coupon = $this->getCoupon();
        $o_start_time = new \DateTime('now');

        $o_ticket = new Ticket($o_room, $o_coupon, $o_start_time);

        $this->assertAttributeEquals($o_start_time, 'start_time', $o_ticket);
    }

    public function testHasStartTimeNotNow()
    {
        $o_room = $this->getRoom();
        $o_coupon = $this->getCoupon();
        $o_start_time = new \DateTime('2011-01-01 10:00:00');

        $o_ticket = new Ticket($o_room, $o_coupon, $o_start_time);

        $this->assertAttributeEquals($o_start_time, 'start_time', $o_ticket);
    }

    public function testDefaultStatus()
    {
        $o_room = $this->getRoom();
        $o_coupon = $this->getCoupon();
        $o_ticket = new Ticket($o_room, $o_coupon, new \DateTime('now'));

        $s_expected = Ticket::STATUS_CREATED;
        $this->assertAttributeEquals($s_expected, 'status', $o_ticket);
    }

    public function testSetStatus()
    {
        $o_room = $this->getRoom();
        $o_coupon = $this->getCoupon();
        $o_ticket = new Ticket($o_room, $o_coupon, new \DateTime('now'));

        $s_expected = Ticket::STATUS_CALLING;
        $o_ticket->setStatus($s_expected);

        $this->assertAttributeEquals($s_expected, 'status', $o_ticket);
    }

}