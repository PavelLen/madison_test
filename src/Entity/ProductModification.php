<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductModificationRepository")
 */
class ProductModification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $size;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $vendorCode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="modifications", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PriceForThePeriod", mappedBy="productPricePeriodModification")
     */
    private $pricePeriod;

    public function __construct()
    {
        $this->pricePeriod = new ArrayCollection();
    }

    public function getName()
    {
        return $this->getProduct()->getName();
    }

    public function getPrice()
    {
        return $this->getProduct()->getPrice();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getVendorCode()
    {
        return $this->vendorCode;
    }

    /**
     * @param mixed $vendorCode
     */
    public function setVendorCode($vendorCode)
    {
        $this->vendorCode = $vendorCode;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getPricePeriod()
    {
        return $this->pricePeriod;
    }

    /**
     * @param mixed $pricePeriod
     */
    public function setPricePeriod($pricePeriod): void
    {
        $this->pricePeriod = $pricePeriod;
    }
}
