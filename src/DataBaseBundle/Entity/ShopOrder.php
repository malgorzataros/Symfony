<?php

namespace DataBaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShopOrder
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DataBaseBundle\Entity\ShopOrderRepository")
 */
class ShopOrder
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="order_number", type="integer", length=255)
     */
    private $orderNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="order_date", type="datetime")
     */
    private $orderDate;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="shopOrder")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="shopOrders")
     * @ORM\JoinTable ()
     */
    private $products;

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
     * Set orderNumber
     *
     * @param string $orderNumber
     * @return ShopOrder
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return string 
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set orderDate
     *
     * @param \DateTime $orderDate
     * @return ShopOrder
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * Get orderDate
     *
     * @return \DateTime 
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * Set custumer
     *
     * @param \DataBaseBundle\Entity\Customer $custumer
     * @return ShopOrder
     */
    public function setCustomer(\DataBaseBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get custumer
     *
     * @return \DataBaseBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add products
     *
     * @param \DataBaseBundle\Entity\Product $products
     * @return ShopOrder
     */
    public function addProduct(\DataBaseBundle\Entity\Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \DataBaseBundle\Entity\Product $products
     */
    public function removeProduct(\DataBaseBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
}
