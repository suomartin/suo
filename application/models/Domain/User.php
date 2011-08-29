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
    protected $work_with_ticket;

    /**
     * @ManyToMany(targetEntity="Room", mappedBy="users")
     * @JoinTable(name="users_rooms")
     */
    protected $rooms;

    public function __construct($last_name,
            $first_name = '', $second_name = '', $password = '', $work_with_ticket = true)
    {
        if ('' === $last_name) {
            throw new \DomainException('User last name cannot be empty');
        }
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->second_name = $second_name;
        if ('' === $password) {
            throw new \DomainException('Password cannot be empty');
        }
        $this->password = $password;
        $this->work_with_ticket = $work_with_ticket;

        $this->rooms = new ArrayCollection();
    }

    public function setWorkWithTicket($b_work_with_ticket)
    {
        $this->work_with_ticket = $b_work_with_ticket;

        return $this;
    }

}
