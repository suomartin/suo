<?php

namespace Domain;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="user")
 */
class User
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
    protected $last_name;

    /**
     * @Column(type="string", length=50)
     */
    protected $first_name;

    /**
     * @Column(type="string", length=50)
     */
    protected $second_name;

    /**
     * @Column(type="string", length=50)
     */
    protected $password;

    /**
     * @Column(type="boolean")
     */
    protected $ticket_user;

    /**
     * @ManyToMany(targetEntity="Room", mappedBy="users")
     * @JoinTable(name="users_rooms")
     */
    protected $rooms;

    public function __construct($last_name, $first_name = '', $second_name = '', $ticket_user = true)
    {
        if (!$last_name) {
            throw new \DomainException('User last name cannot be empty');
        }
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->second_name = $second_name;
        $this->ticket_user = $ticket_user;

        $this->rooms = new ArrayCollection();
    }

}
