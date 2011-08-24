<?php

namespace Domain;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="room")
 */
class Room
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string", length=50)
     */
    protected $number;

    /**
     * @Column(type="string", length=50)
     */
    protected $description;

    /**
     * @ManyToMany(targetEntity="Atm", mappedBy="rooms")
     * @JoinTable(name="atms_rooms")
     */
    protected $atms;

    /**
     * @Column(type="boolean")
     */
    protected $record;

    public function __construct($number, $description, $record = true)
    {
        $this->number = $number;
        if (!$description) {
            throw new \DomainException('Room description cannot be empty');
        }
        $this->description = $description;

        $this->atms = new \Doctrine\Common\Collections\ArrayCollection();

        $this->record = $record;
    }

}
