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

    protected function setUp()
    {
        $this->o_em_mock = $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false);
        $o_repository_mock_builder = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
                                      ->disableOriginalConstructor();
        $this->o_room_repository_mock = $o_repository_mock_builder->getMock();

        \ServiceLocator::setEm($this->o_em_mock);
        \ServiceLocator::setRoomRepository($this->o_room_repository_mock);
    }

    /**
     * @return \Services\TicketService
     */
    protected function getService()
    {
        return \ServiceLocator::getTicketService();
    }

    public function testFindRoomById()
    {
        $n_room_id = 10;

        $this->o_room_repository_mock
            ->expects($this->once())
            ->method('find')
            ->with($this->equalTo($n_room_id))
            ->will($this->returnValue($this->getMock('Domain\Room', array(), array(), '', false)));

        $this->getService()->addTicket($n_room_id);
    }

    public function testRoomIsNotFound()
    {
        $this->o_room_repository_mock
            ->expects($this->once())
            ->method('find')
            ->with($this->anything())
            ->will($this->returnValue(null));
        $this->setExpectedException('DomainException', 'Room is not found');

        $this->getService()->addTicket(10);
    }
}
