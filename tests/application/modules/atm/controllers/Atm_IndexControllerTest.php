<?php

/**
 * Test class for Atm_IndexController.
 * Generated by PHPUnit on 2011-09-05 at 21:49:15.
 */
class Atm_IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    CONST ATM_IP_ADDRESS = '127.0.0.1';

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $o_em_mock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $o_atm_repository_mock;

    public function setUp()
    {
        $this->o_em_mock = $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false);
        $o_repository_mock_builder = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
                                      ->disableOriginalConstructor();
        //$this->o_atm_repository_mock = $o_repository_mock_builder->getMock();
        $this->o_atm_repository_mock = $this->getMock('Domain\AtmRepository', array(), array(), '', false);

        \ServiceLocator::setEm($this->o_em_mock);
        \ServiceLocator::setRepository('Atm', $this->o_atm_repository_mock);

        $_SERVER['REMOTE_ADDR'] = self::ATM_IP_ADDRESS;

        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testIndexActionNoTerminalAddress()
    {
        $s_expected_exception_message = 'No Atm with address ' . self::ATM_IP_ADDRESS;

        $this->o_atm_repository_mock
            ->expects($this->any())
            ->method('findRoomsByNetAddress')
            ->will($this->throwException(new \DomainException($s_expected_exception_message)));

        $params = array('action' => 'index', 'controller' => 'index', 'module' => 'atm');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('#error', $s_expected_exception_message);
    }

    public function testIndexActionNoRoomsToTerminalAddress()
    {
        $s_expected_exception_message = 'No Rooms to Atm with address ' . self::ATM_IP_ADDRESS;

        $this->o_atm_repository_mock
            ->expects($this->any())
            ->method('findRoomsByNetAddress')
            ->will($this->throwException(new \DomainException($s_expected_exception_message)));

        $params = array('action' => 'index', 'controller' => 'index', 'module' => 'atm');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('#error', $s_expected_exception_message);
    }

    public function testIndexAction2RoomsToTerminalAddress()
    {
        $o_room1 = new Domain\Room('1', 'test_description_1');
        $o_room2 = new Domain\Room('2', 'test_description_2');

        $this->o_atm_repository_mock
            ->expects($this->any())
            ->method('findRoomsByNetAddress')
            ->will($this->returnValue(array($o_room1, $o_room2)));

        $params = array('action' => 'index', 'controller' => 'index', 'module' => 'atm');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('#rooms', 'test_description_1');
        $this->assertQueryContentContains('#rooms', 'test_description_2');
    }

}