<?php

namespace Domain;

use Doctrine\Common\Collections\ArrayCollection;

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
     * @ManyToOne(targetEntity="Room")
     */
    protected $room;

    public function __construct(Room $o_room, $s_start_date = 'now', $s_start_time = 'now')
    {
        $this->creation_time = new \DateTime('now');
        $this->start_date = new \DateTime($s_start_date);
        $this->start_time = new \DateTime($s_start_time);

        $this->room = $o_room;
    }
}
