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

        if (!empty($id = $request->request->get('pricePeriodId'))){
            $newDateFrom = new \DateTime($request->request->get('newPeriodFrom').'00:00:00');
            $newDateTo = new \DateTime($request->request->get('newPeriodTo'));
            $newPrice = trim($request->request->get('newPeriodPrice'));

            $pricePeriod = $doctrine->getRepository(PriceForThePeriod::class)->find($id);

            $pricePeriod->setDateFrom($newDateFrom);
            $pricePeriod->setDateTo($newDateTo);
            $pricePeriod->setPrice($newPrice);

            $doctrine->getManager()->persist($pricePeriod);
            $doctrine->getManager()->flush();

            $returnArrey[] = [
                'id' => $pricePeriod->getID(),
                'dateFrom' => date_format($pricePeriod->getDateFrom(), 'Y-m-d'),
                'dateTo' => date_format($pricePeriod->getDateTo(), 'Y-m-d'),
                'price' => $pricePeriod->getPrice()
            ];

            return new JsonResponse($returnArrey);
        }
        $content = $twig->render('admin/admin.html.twig', ['products' => $products]);
        $response = new Response();
        $response->setContent($content);
        return $response;
    }
}