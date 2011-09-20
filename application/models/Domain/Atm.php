<?php

namespace Domain;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Domain\AtmRepository")
 * @Table(name="atm")
 */
class Atm
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string", length=15, unique=true)
     */
    protected $netaddress;

    /**
     * @Column(type="string", length=50)
     */
    protected $description;

    /**
     * @ManyToMany(targetEntity="Room", inversedBy="users")
     * @JoinTable(name="atms_rooms")
     */
    protected $rooms;

    public function __construct($netaddress, $description = '')
    {
        if ('' === $netaddress) {
            throw new \DomainException('Net address cannot be empty');
        }
        $this->netaddress = $netaddress;
        $this->description = $description;

        $this->rooms = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNetaddress()
    {
        return $this->netaddress;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getRooms()
    {
        return $this->rooms;
    }
}