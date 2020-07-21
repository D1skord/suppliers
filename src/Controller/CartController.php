<?php

namespace App\Controller;

use App\Entity\Supplier;
use App\Entity\SupplierProduct;
use App\Entity\SupplierProductRoot;
use App\Entity\SupplierProductType;
use App\Entity\SupplierStaffer;
use App\Form\AddProductRootFormType;
use App\Form\AddProductTypeFormType;
use App\Form\AddSupplierFormType;
use App\Form\AddSupplierProductFormType;
use App\Form\AddSupplierStufferFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CartController extends AbstractController
{
    /**
     * Страница корзины
     *
     * @Route("/cart", name="cart")
     */
    public function index(Request $request)
    {
        $jsonCart = $request->cookies->get('cart');
        $cart = !empty($jsonCart) ? json_decode($jsonCart, true) : [];

        foreach ($cart as $productId) {
            $productIds[] = $productId;
        }

        if (!empty($productIds)) {
            $products = $this->getDoctrine()->getRepository(SupplierProduct::class)->findBy(['id' => $productIds]);
        } else {
            $products = [];
        }

        return $this->render(
            'cart/index.html.twig',
            [
                'products' => $products,
                'cart' => $cart
            ]
        );
    }

}