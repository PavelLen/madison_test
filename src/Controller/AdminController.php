<?php

namespace App\Controller;


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

        if (!empty($id = $request->request->get('id'))){
            $product = $doctrine->getRepository(Product::class)->find($id);
            $modifications = $product->getModifications();
            $arr = [];
            foreach ($modifications as $modification){
                $arr[] = [
                    'id' => $modification->getId(),
                    'color' => $modification->getColor(),
                    'size' => $modification->getSize(),
                    'vendorCode' => $modification->getVendorCode()
                ];
            }
            return new JsonResponse($arr);
        }
        $content = $twig->render('admin/admin.html.twig', ['products' => $products]);
        $response = new Response();
        $response->setContent($content);
        return $response;
    }

    /**
     * @Route("/admin/", requirements={"id" = "\d+"}, name="edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request)
    {
        echo $id = $request->request->get('id');
        die();
        $doctrine = $this->getDoctrine();
        $product = $doctrine->getRepository(Product::class)->find($id);
        $modifications = $product->getModifications();

        $test = ['a' => $id];

        return new JsonResponse($test);
    }

    /**
     * @Route("/show/{id}/{modificationId}", requirements={"id" = "\d+"}, name="show_modification")
     * @Method({"GET", "POST"})
     */
    public function showModification($id, $modificationId)
    {
        $doctrine = $this->getDoctrine();
        $product = $doctrine->getRepository(Product::class)->find($id);
        $modification = $product->getModifications()[0];
        $modification = $doctrine->getRepository(ProductModification::class)->find($modificationId);

        var_dump($modification); die();

        return new JsonResponse($modification);
    }

}