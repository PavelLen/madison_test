<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PriceForThePeriodRepository")
 * @UniqueEntity(fields={"dateFrom, dateTo, $price"},
 *     message="This period already exists."
 * )
 */
class PriceForThePeriod
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="date_from", type="datetime")
     */
    private $dateFrom;

    /**
     * @ORM\Column(name="date_to", type="datetime")
     */
    private $dateTo;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductModification", inversedBy="pricePeriod", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $productPricePeriodModification ;

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
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param mixed $dateFrom
     */
    public function setDateFrom($dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return mixed
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param mixed $dateTo
     */
    public function setDateTo($dateTo): void
    {
        $this->dateTo = $dateTo;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getProductPricePeriodModification()
    {
        return $this->productPricePeriodModification;
    }

    /**
     * @param mixed $productPricePeriodModification
     */
    public function setProductPricePeriodModification($productPricePeriodModification): void
    {
        $this->productPricePeriodModification = $productPricePeriodModification;
    }
}
