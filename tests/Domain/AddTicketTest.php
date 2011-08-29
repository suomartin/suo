<?php

namespace Test\Domain;

class AddTicketTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $o_em_mock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $o_room_repository_mock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $o_coupon_repository_mock;

    protected function setUp()
    {
        $this->o_em_mock = $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false);
        $o_repository_mock_builder = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
                                      ->disableOriginalConstructor();
        $this->o_room_repository_mock = $o_repository_mock_builder->getMock();
        $this->o_coupon_repository_mock = $o_repository_mock_builder->getMock();

        \ServiceLocator::setEm($this->o_em_mock);
        \ServiceLocator::setRepository('Room', $this->o_room_repository_mock);
        \ServiceLocator::setRepository('Coupon', $this->o_coupon_repository_mock);
    }

    /**
     * @return \Services\TicketService
     */
    protected function getService()
    {
        return \ServiceLocator::getTicketService();
    }

    protected function mockRoomLookupById()
    {
        return $this->o_room_repository_mock
            ->expects($this->once())
            ->method('find')
            ->with($this->anything())
            ->will($this->returnValue($this->getMock('Domain\Room', array(), array(), '', false)));
    }

    protected function mockCouponLookupByDate($return_value)
    {
        return $this->o_coupon_repository_mock
            ->expects($this->once())
            ->method('findBy')
            ->with($this->anything(), $this->anything(), $this->anything(), $this->anything())
            ->will($this->returnValue($return_value));
    }

    public function testFindRoomById()
    {
        $n_room_id = 10;

        $this->o_room_repository_mock
            ->expects($this->once())
            ->method('find')
            ->with($this->equalTo($n_room_id))
            ->will($this->returnValue($this->getMock('Domain\Room', array(), array(), '', false)));

        $this->getService()->addTicket($n_room_id, 'now');
    }

    public function testRoomIsNotFound()
    {
        $this->o_room_repository_mock
            ->expects($this->once())
            ->method('find')
            ->with($this->anything())
            ->will($this->returnValue(null));
        $this->setExpectedException('DomainException', 'Room is not found');

        $this->getService()->addTicket(10, 'now');
    }

    public function testWrongDate()
    {
        $this->mockRoomLookupById();

        $this->setExpectedException('Exception', 'Start date is not correct');

        $this->getService()->addTicket(10, '2011-01-01 10:00:a');
    }

    public function testFindMaxCouponNumberByDateWithTodayDate()
    {
        $this->mockRoomLookupById();
        $s_date = 'now';
        $o_date = new \DateTime($s_date);

        $this->o_coupon_repository_mock
            ->expects($this->once())
            ->method('findBy')
            ->with($this->equalTo(array('start_date' => $o_date)),
                    $this->equalTo(array('number' => 'ASC')),
                    $this->equalTo(1),
                    $this->equalTo(0))
            ->will($this->returnValue(null));

        $this->getService()->addTicket(10, $s_date);
    }

    public function testFindMaxCouponNumberByDateWithNotTodayDate()
    {
        $this->mockRoomLookupById();
        $s_date = '2011-01-01';
        $o_date = new \DateTime($s_date);

        $this->o_coupon_repository_mock
            ->expects($this->once())
            ->method('findBy')
            ->with($this->equalTo(array('start_date' => $o_date)),
                    $this->equalTo(array('number' => 'ASC')),
                    $this->equalTo(1),
                    $this->equalTo(0))
            ->will($this->returnValue(null));

        $this->getService()->addTicket(10, $s_date);
    }

    public function testFindMaxCouponNumberByDateAndCouponNotFound()
    {
        $n_coupon_number_expected = 1;

        $this->mockRoomLookupById();
        $this->mockCouponLookupByDate(null);

        $o_ticket = $this->getService()->addTicket(10, 'now');

        $this->assertEquals($n_coupon_number_expected, $o_ticket->getCouponNumber());
    }

    public function testFindMaxCouponNumberByDateAndCouponFound()
    {
        $n_coupon_number_expected = 5;

        $o_coupon_mock = $this->getMock('Domain\Coupon', array('getNumber'), array(), '', false);
        $o_coupon_mock->expects($this->once())
                ->method('getNumber')
                ->will($this->returnValue($n_coupon_number_expected - 1));

        $this->mockRoomLookupById();
        $this->mockCouponLookupByDate(array($o_coupon_mock));

        $o_ticket = $this->getService()->addTicket(10, 'now');

        $this->assertEquals($n_coupon_number_expected, $o_ticket->getCouponNumber());
    }


}
