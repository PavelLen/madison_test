<?php

namespace App\DataFixtures;

use App\Entity\PriceForThePeriod;
use App\Entity\Product;
use App\Entity\ProductModification;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setName('School uniform "xBoy"');
        $product->setGender('Male');
        $product->setPrice('10000.00');
        $product->setCurrency('руб');

        $modification = new ProductModification();
        $modification->setSize('L');
        $modification->setColor('Black');
        $modification->setVendorCode(uniqid());
        $modification->setProduct($product);

        $pricePeriod = new PriceForThePeriod();
        $pricePeriod->setDateFrom(new \DateTime("2016-01-01 00:00:00"));
        $pricePeriod->setDateTo(new \DateTime("2016-05-01 00:00:00"));
        $pricePeriod->setPrice('8000.00');
        $pricePeriod->setProductPricePeriodModification($modification);

        $manager->persist($product);
        $manager->persist($modification);
        $manager->persist($pricePeriod);

        $pricePeriod = new PriceForThePeriod();
        $pricePeriod->setDateFrom(new \DateTime("2016-05-01 00:00:00"));
        $pricePeriod->setDateTo(new \DateTime("2017-01-01 00:00:00"));
        $pricePeriod->setPrice('12000.00');
        $pricePeriod->setProductPricePeriodModification($modification);

        $manager->persist($pricePeriod);

        $pricePeriod = new PriceForThePeriod();
        $pricePeriod->setDateFrom(new \DateTime("2016-06-01 00:00:00"));
        $pricePeriod->setDateTo(new \DateTime("2017-09-10 00:00:00"));
        $pricePeriod->setPrice('15000.00');
        $pricePeriod->setProductPricePeriodModification($modification);

        $manager->persist($pricePeriod);

        $pricePeriod = new PriceForThePeriod();
        $pricePeriod->setDateFrom(new \DateTime("2017-06-01 00:00:00"));
        $pricePeriod->setDateTo(new \DateTime("2017-10-20 00:00:00"));
        $pricePeriod->setPrice('20000.00');
        $pricePeriod->setProductPricePeriodModification($modification);

        $manager->persist($pricePeriod);

        $pricePeriod = new PriceForThePeriod();
        $pricePeriod->setDateFrom(new \DateTime("2016-12-15 00:00:00"));
        $pricePeriod->setDateTo(new \DateTime("2017-12-31 00:00:00"));
        $pricePeriod->setPrice('5000.00');
        $pricePeriod->setProductPricePeriodModification($modification);

        $manager->persist($pricePeriod);

        $pricePeriod = new PriceForThePeriod();
        $pricePeriod->setDateFrom(new \DateTime("2018-02-25 00:00:00"));
        $pricePeriod->setDateTo(new \DateTime("2018-02-27 00:00:00"));
        $pricePeriod->setPrice('8888.00');
        $pricePeriod->setProductPricePeriodModification($modification);

        $manager->persist($pricePeriod);


        $product = new Product();
        $product->setName('School uniform "Helen"');
        $product->setGender('Female');
        $product->setPrice('11000.00');
        $product->setCurrency('руб');

        $modification = new ProductModification();
        $modification->setSize('L');
        $modification->setColor('white');
        $modification->setVendorCode(uniqid());
        $modification->setProduct($product);

        $pricePeriod = new PriceForThePeriod();
        $pricePeriod->setDateFrom(new \DateTime("2018-01-01 00:00:00"));
        $pricePeriod->setDateTo(new \DateTime("2018-02-25 00:00:00"));
        $pricePeriod->setPrice('10000.00');
        $pricePeriod->setProductPricePeriodModification($modification);

        $manager->persist($product);
        $manager->persist($modification);
        $manager->persist($pricePeriod);

        $modification = new ProductModification();
        $modification->setSize('S');
        $modification->setColor('Grey');
        $modification->setVendorCode(uniqid());
        $modification->setProduct($product);


        $pricePeriod = new PriceForThePeriod();
        $pricePeriod->setDateFrom(new \DateTime("2018-01-26 00:00:00"));
        $pricePeriod->setDateTo(new \DateTime("2018-02-27 00:00:00"));
        $pricePeriod->setPrice('9999.00');
        $pricePeriod->setProductPricePeriodModification($modification);

        $manager->persist($modification);
        $manager->persist($pricePeriod);

        $manager->flush();
    }
}