<?php

namespace DataBaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @ORM\Entity
 */

class Product {
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
     * @ORM\Column(type="text")
     */
    private $description;
    /**
     * @ORM\Column(type="decimal", precision=9, scale=2)
     */
    private $price;
    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity="ShopOrder", mappedBy="products")
     */
    private $shopOrders;

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
     * @return Product
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
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shopOrders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add shopOrders
     *
     * @param \DataBaseBundle\Entity\ShopOrder $shopOrders
     * @return Product
     */
    public function addShopOrder(\DataBaseBundle\Entity\ShopOrder $shopOrders)
    {
        $this->shopOrders[] = $shopOrders;

        return $this;
    }

    /**
     * Remove shopOrders
     *
     * @param \DataBaseBundle\Entity\ShopOrder $shopOrders
     */
    public function removeShopOrder(\DataBaseBundle\Entity\ShopOrder $shopOrders)
    {
        $this->shopOrders->removeElement($shopOrders);
    }

    /**
     * Get shopOrders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShopOrders()
    {
        return $this->shopOrders;
    }
}
