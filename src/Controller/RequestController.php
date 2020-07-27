<?php

namespace App\Controller;

use App\Entity\RequestItem;
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
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class RequestController extends AbstractController
{

    /**
     * Страница заявок
     *
     * @param Request $request
     * @param Response $response
     * @param ValidatorInterface $validator
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/requests", name="request_list")
     */
    public function list(Request $request, ValidatorInterface $validator)
    {
        $requests = $this->getDoctrine()->getRepository(\App\Entity\Request::class)->findAll();

        return $this->render(
            'request/list.html.twig',
            [
                'requests' => $requests
            ]
        );
    }

    /**
     * Создание заявки
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/requests/add", name="request_add")
     * @throws \Exception
     */
    public function add(Request $request)
    {
        $jsonCart = $request->cookies->get('cart');
        $cart = !empty($jsonCart) ? json_decode($jsonCart, true) : [];

        foreach ($cart as $cartItem) {
            $productIds[] = $cartItem['id'];
        }

        // Если корзина пустая
        if (empty($productIds)) {
            $this->addFlash(
                'warning',
                'Заявка не может быть без пустой!'
            );

            return $this->redirectToRoute('cart');
        }

        // Товары в корзине
        $products = $this->getDoctrine()->getRepository(SupplierProduct::class)->findBy(['id' => $productIds]);

        $prodRequest = new \App\Entity\Request();
        $prodRequestItem = new RequestItem();

        // Заполняем элементы заявки
        $prodRequestItems = [];
        foreach ($products as $product) {
            $prodRequestItem = new RequestItem();
            $prodRequestItem->setProduct($product);
            $prodRequestItem->setQuantity($cart[$product->getId()]['quantity']);
            $prodRequestItems[] = $prodRequestItem;
        }

        // Заполняем заявку элементами
        foreach ($prodRequestItems as $prodRequestItem) {
            $prodRequest->addItem($prodRequestItem);
        }

        // Устанавливаем дату заявки
        $prodRequest->setDate(new \DateTime());
        $prodRequest->setCompleted(0);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($prodRequest);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Заявка создана!'
        );

        $res = new Response();
        $res->headers->clearCookie('cart');
        $res->send();
        return $this->redirectToRoute('request_list');
    }

    /**
     * Заверщение заявки
     *
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/requests/{id}/complete", name="request_complete")
     */
    public function complete(Request $request, int $id)
    {
        $supplierRequest = $this->getDoctrine()->getRepository(\App\Entity\Request::class)->find($id);

        $supplierRequest->setCompleted(1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($supplierRequest);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Заявка завершена!'
        );

        return $this->redirectToRoute('request_list');
    }
}