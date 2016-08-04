<?php

namespace DataBaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Customer
 * @ORM\Entity
 */
class Customer {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="string")
     */
    private $address;
    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="ShopOrder", mappedBy="customer")
     */
    private $shopOrder;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Customer
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shopOrder = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add shopOrder
     *
     * @param \DataBaseBundle\Entity\ShopOrder $shopOrder
     * @return Customer
     */
    public function addShopOrder(\DataBaseBundle\Entity\ShopOrder $shopOrder)
    {
        $this->shopOrder[] = $shopOrder;

        return $this;
    }

    /**
     * Remove shopOrder
     *
     * @param \DataBaseBundle\Entity\ShopOrder $shopOrder
     */
    public function removeShopOrder(\DataBaseBundle\Entity\ShopOrder $shopOrder)
    {
        $this->shopOrder->removeElement($shopOrder);
    }

    /**
     * Get shopOrder
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShopOrder()
    {
        return $this->shopOrder;
    }
}
