<?php

namespace Domain;

/**
 * @Entity
 * @Table(name="coupon")
 */
class Coupon
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="date")
     */
    protected $start_date;

    /**
     * @Column(type="integer")
     */
    protected $number;

    public function __construct(\DateTime $start_date, $number)
    {var_dump($number);
        $this->start_date = $start_date;
        if ('' === $number) {
            throw new \DomainException('Coupon number cannot be empty');
        }
        $this->number = $number;
    }

    public function getNumber()
    {
        return $this->number;
    }

}
