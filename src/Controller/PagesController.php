<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductModification;
use App\Utils\CheckPeriod;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class PagesController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home(Environment $twig, Request $request)
    {
        $doctrine = $this->getDoctrine();
        $products = $doctrine->getRepository(Product::class)->findAll();
        $productsArr = [];
        $now = new \DateTime();
        $checkPeriod = new CheckPeriod();

        /**
         * Find the current price
         */
        foreach ($products as $product){
            $price = $product->getPrice();
            $modifications = $product->getModifications();
            foreach ($modifications as $modification){
                $pricePeriods = $modification->getPricePeriod();
                foreach ($pricePeriods as $pricePeriod){
                    if ($checkPeriod->isDateBetweenDates($now, $pricePeriod->getDateFrom(), $pricePeriod->getDateTo())){
                        $price = $pricePeriod->getPrice();
                    }
                }
            }
            $productsArr[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'gender' => $product->getGender(),
                'currency' => $product->getCurrency(),
                'price' => $price
            ];
        }

        $products = $productsArr;

        $products = array_chunk($products, 3);

        $content = $twig->render('pages/home.html.twig', ['products' => $products]);
        $response = new Response();
        $response->setContent($content);
        return $response;
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(Environment $twig)
    {
        $content = $twig->render('pages/about.html.twig');
        $response = new Response();
        $response->setContent($content);
        return $response;
    }

    /**
     * @Route("/show/{id}", requirements={"id" = "\d+"}, name="show")
     * @Method({"GET", "POST"})
     */
    public function show(Environment $twig, $id)
    {
        $doctrine = $this->getDoctrine();
        $product = $doctrine->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $now = new \DateTime();
        $checkPeriod = new CheckPeriod();

        /**
         * Find the current price
         */
        $price = $product->getPrice();
        $modifications = $product->getModifications();
        foreach ($modifications as $modification){
            $pricePeriods = $modification->getPricePeriod();
            foreach ($pricePeriods as $pricePeriod){
                if ($checkPeriod->isDateBetweenDates($now, $pricePeriod->getDateFrom(), $pricePeriod->getDateTo())){
                    $price = $pricePeriod->getPrice();
                }
            }
        }

        $content = $twig->render('pages/show.html.twig', ['product' => $product, 'price' => $price]);
        $response = new Response();
        $response->setContent($content);
        return $response;
    }

    /**
     * @Route("/show/{id}/{modificationId}", requirements={"id" = "\d+"}, name="show_modification")
     * @Method({"GET", "POST"})
     */
    public function showModification($id, $modificationId)
    {
        $doctrine = $this->getDoctrine();
        $product = $doctrine->getRepository(Product::class)->find($id);
        $modification = $doctrine->getRepository(ProductModification::class)->find($modificationId);
        $periods = $modification->getPricePeriod();

        $now = new \DateTime();
        $checkPeriod = new CheckPeriod();
        $nowPrice = $product->getPrice();

        foreach ($periods as $period){
            if ($checkPeriod->isDateBetweenDates($now, $period->getDateFrom(), $period->getDateTo())){
                $nowPrice = $period->getPrice();
            }
        }

        return new JsonResponse(['vendorCode' => $modification->getVendorCode(), 'color' => $modification->getColor(),
            'size' => $modification->getSize(), 'price' => $nowPrice]);
    }

}