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
     * @Column(type="boolean")
     */
    protected $can_record;

    /**
     * @ManyToMany(targetEntity="Atm", mappedBy="rooms")
     * @JoinTable(name="atms_rooms")
     */
    protected $atms;

    /**
     * @ManyToMany(targetEntity="User", mappedBy="rooms")
     * @JoinTable(name="users_rooms")
     */
    protected $users;

    public function __construct($number, $description, $can_record = true)
    {
        $this->number = $number;
        if ('' === $description) {
            throw new \DomainException('Room description cannot be empty');
        }
        $this->description = $description;

        $this->can_record = $can_record;

        $this->atms = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

}
