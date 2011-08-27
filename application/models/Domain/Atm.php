<?php

namespace Domain;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
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
     * @Column(type="string", length=15)
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

    public function __construct($netaddress, $description)
    {
        if (!$netaddress) {
            throw new \DomainException('Net address cannot be empty');
        }
        $this->netaddress = $netaddress;
        $this->description = $description;

        $this->rooms = new ArrayCollection();
    }
}