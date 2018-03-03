<?php

namespace App\Controller;


use App\Entity\PriceForThePeriod;
use App\Entity\Product;
use App\Entity\ProductModification;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     * @Method({"GET", "POST"})
     */
    public function admin(Environment $twig, Request $request)
    {
        $doctrine = $this->getDoctrine();
        $products = $doctrine->getRepository(Product::class)->findAll();

        /**
         * New Price Period
         */
        if (!empty($id = $request->request->get('newPricePeriod')))
        {
            $newDateFrom = $request->request->get('newPeriodFrom');
            $newDateTo = $request->request->get('newPeriodTo');
            $newPrice = trim($request->request->get('newPeriodPrice'));

            if (empty($newPrice) || $newPrice == 0){
                return new JsonResponse(['error' => 'Прайс не может быть нулевым']);
            } elseif ($newDateFrom > $newDateTo){
                return new JsonResponse(['error' => 'Дата начала выше даты окончания']);
            } else {
                if (empty($newDateFrom)){
                    $newDateFrom = new \DateTime();
                } else {
                    $newDateFrom = new \DateTime($request->request->get('newPeriodFrom'));
                }

                if (empty($newDateTo)){
                    $newDateTo = new \DateTime();
                    $newDateTo = $newDateTo->modify('+1 day');
                } else {
                    $newDateTo = new \DateTime($request->request->get('newPeriodTo'));
                }

                $modification = $doctrine->getRepository(ProductModification::class)->find($id);

                $newPricePeriod = new PriceForThePeriod();

                $newPricePeriod->setDateFrom($newDateFrom);
                $newPricePeriod->setDateTo($newDateTo);
                $newPricePeriod->setPrice($newPrice);
                $newPricePeriod->setProductPricePeriodModification($modification);

                $doctrine->getManager()->persist($newPricePeriod);
                $doctrine->getManager()->flush();

                $responseArrey = [
                    'action'=>"Addition of the price period was successful. Assigned to id:".$newPricePeriod->getID(),
                    'id' => $newPricePeriod->getID(),
                    'dateFrom' => date_format($newPricePeriod->getDateFrom(), 'Y-m-d'),
                    'dateTo' => date_format($newPricePeriod->getDateTo(), 'Y-m-d'),
                    'price' => $newPricePeriod->getPrice()
                ];

                return new JsonResponse($responseArrey);
            }
        }
        /**
         * Edit Price Period
         */
        elseif (!empty($id = $request->request->get('editPricePeriodId')))
        {
            $newDateFrom = new \DateTime($request->request->get('newPeriodFrom'));
            $newDateTo = new \DateTime($request->request->get('newPeriodTo'));
            $newPrice = trim($request->request->get('newPeriodPrice'));
            if (empty($newPrice) || $newPrice == 0){
                return new JsonResponse(['error' => 'Прайс не может быть нулевым']);
            } elseif ($newDateFrom > $newDateTo){
                return new JsonResponse(['error' => 'Дата начала выше даты окончания']);
            } else {
                $editPricePeriod = $doctrine->getRepository(PriceForThePeriod::class)->find($id);

                $editPricePeriod->setDateFrom($newDateFrom);
                $editPricePeriod->setDateTo($newDateTo);
                $editPricePeriod->setPrice($newPrice);

                $doctrine->getManager()->persist($editPricePeriod);
                $doctrine->getManager()->flush();

                $responseArrey = [
                    'action'=>"Changes in the price period with id:$id were successful",
                    'id' => $editPricePeriod->getID(),
                    'dateFrom' => date_format($editPricePeriod->getDateFrom(), 'Y-m-d'),
                    'dateTo' => date_format($editPricePeriod->getDateTo(), 'Y-m-d'),
                    'price' => $editPricePeriod->getPrice()
                ];
                return new JsonResponse($responseArrey);
            }
        /**
         * Delete Price Period
         */
        } elseif (!empty($id = $request->request->get('deletePricePeriodId')))
        {
            $deletePricePeriod = $doctrine->getRepository(PriceForThePeriod::class)->find($id);
            if($deletePricePeriod){
                $em = $this->getDoctrine()->getManager();
                $em->remove($deletePricePeriod);
                $em->flush();

                return new JsonResponse(['action'=>"Removing the price period with the id:$id was successful", 'id'=>$id]);
            } else {
                return new JsonResponse(['error' => "No price period found for id.$id"]);
            }
        }

        $content = $twig->render('admin/admin.html.twig', ['products' => $products]);
        $response = new Response();
        $response->setContent($content);
        return $response;
    }
}