<?php

namespace Domain;

/**
 * @Entity
 * @Table(name="ticket")
 */
class Ticket
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="datetime")
     */
    protected $creation_time;

    /**
     * @Column(type="date")
     */
    protected $start_date;

    /**
     * @Column(type="time")
     */
    protected $start_time;

    /**
     * @Column(type="string", length=50)
     */
    protected $status;

    /**
     * @ManyToOne(targetEntity="Room")
     */
    protected $room;

    /**
     * @ManyToOne(targetEntity="User")
     */
    protected $user;

    /**
     * @ManyToOne(targetEntity="Coupon")
     */
    protected $coupon;

    const STATUS_CREATED = 'created';
    const STATUS_IN_QUEUE = 'in_queue';
    const STATUS_CALLING = 'calling';
    const STATUS_CLOSED = 'closed';

    public function __construct(Room $o_room, Coupon $o_coupon, \DateTime $o_start_time)
    {
        $this->creation_time = new \DateTime('now');
        $this->start_time = $o_start_time;

        $this->room = $o_room;

        $this->status = self::STATUS_CREATED;

        $this->coupon = $o_coupon;
    }

    /**
     * Установка статуса
     *
     * @param enum $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return integer
     */
    public function getCouponNumber()
    {
        return $this->coupon->getNumber();
    }
}
