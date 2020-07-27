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
use App\Service\SupplierService;
use Couchbase\Document;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    /**
     * Страница редактирования товара
     *
     * @param Request $request
     * @param int $supplierId
     * @param int $productId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/suppliers/{supplierId}/product/{productId}/edit", name="supplier_product_edit")
     */
    public function edit(Request $request, int $supplierId, int $productId)
    {
        $supplier = $this->getDoctrine()->getRepository(Supplier::class)->find($supplierId);
        $product = $supplier->getProduct($productId);

        $editSupplierProductForm = $this->createForm(AddSupplierProductFormType::class, $product);
        $editSupplierProductForm->handleRequest($request);

        if ($editSupplierProductForm->isSubmitted() && $editSupplierProductForm->isValid()) {
            $product->setDate(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplier);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Товар изменен!'
            );
            return $this->redirectToRoute('supplier_view', [
                'id' => $supplierId
            ]);
        }

        return $this->render(
            'product/edit.html.twig',
            [
                'editSupplierProductForm' => $editSupplierProductForm->createView(),
                'supplier' => $supplier,
                'product' => $product,
            ]
        );
    }

    /**
     * Удаление товара
     *
     * @param Request $request
     * @param int $id - id товара
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/product/{id}/remove", name="supplier_product_remove")
     */
    public function remove(Request $request, int $id)
    {
        $product = $this->getDoctrine()->getRepository(SupplierProduct::class)->find($id);

        $supplier = $product->getSupplier();
        $supplier->removeProduct($product);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($supplier);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Товар удален!'
        );

        return $this->redirectToRoute('supplier_view', [
            'id' => $supplier->getId()
        ]);
    }

    /**
     * Страница корневых систем
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/products/roots", name="product_root_list")
     */
    public function rootList(Request $request, ValidatorInterface $validator)
    {
        $root = new SupplierProductRoot();
        $addRootForm = $this->createForm(AddProductRootFormType::class, $root);
        $addRootForm->handleRequest($request);

        if ($addRootForm->isSubmitted() && $addRootForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($root);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Корневая система добавлена!'
            );
        }

        $roots = $this->getDoctrine()->getRepository(SupplierProductRoot::class)->findAll();

        return $this->render(
            'product/root/list.html.twig',
            [
                'addRootForm' => $addRootForm->createView(),
                'roots' => $roots
            ]
        );
    }

    /**
     * Страница редактирования корневой системы
     *
     * @param Request $request
     * @param int $id - id корневой системы
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/products/roots/{id}/edit", name="product_root_edit")
     */
    public function rootEdit(Request $request, int $id)
    {
        $root = $this->getDoctrine()->getRepository(SupplierProductRoot::class)->find($id);

        $editRootForm = $this->createForm(AddProductRootFormType::class, $root);
        $editRootForm->handleRequest($request);

        if ($editRootForm->isSubmitted() && $editRootForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($root);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Корневая система изменена!'
            );
            return $this->redirectToRoute('product_root_list');
        }

        return $this->render(
            'product/root/edit.html.twig',
            [
                'editRootForm' => $editRootForm->createView(),
            ]
        );
    }

    /**
     * Удаление корневой системы
     *
     * @param Request $request
     * @param int $id - id корневой системы
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/products/roots/{id}/remove", name="product_root_remove")
     */
    public function rootRemove(Request $request, int $id)
    {
        $root = $this->getDoctrine()->getRepository(SupplierProductRoot::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($root);
        try {
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Корневая система удалена!'
            );
        } catch (\Exception $e) {
            $this->addFlash(
                'warning',
                'Корневая система используется!'
            );
        }


        return $this->redirectToRoute('product_root_list');
    }

    /**
     * Страница типов
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/products/types", name="product_type_list")
     */
    public function typeList(Request $request, ValidatorInterface $validator)
    {
        $type = new SupplierProductType();
        $addTypeForm = $this->createForm(AddProductTypeFormType::class, $type);
        $addTypeForm->handleRequest($request);

        if ($addTypeForm->isSubmitted() && $addTypeForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($type);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Тип добавлен!'
            );
        }

        $types = $this->getDoctrine()->getRepository(SupplierProductType::class)->findAll();

        return $this->render(
            'product/type/list.html.twig',
            [
                'addTypeForm' => $addTypeForm->createView(),
                'types' => $types
            ]
        );
    }

    /**
     * Страница редактирования типа
     *
     * @param Request $request
     * @param int $id - id корневой системы
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/products/types/{id}/edit", name="product_type_edit")
     */
    public function typeEdit(Request $request, int $id)
    {
        $type = $this->getDoctrine()->getRepository(SupplierProductType::class)->find($id);

        $editTypeForm = $this->createForm(AddProductTypeFormType::class, $type);
        $editTypeForm->handleRequest($request);

        if ($editTypeForm->isSubmitted() && $editTypeForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($type);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Тип изменен!'
            );
            return $this->redirectToRoute('product_type_list');
        }

        return $this->render(
            'product/type/edit.html.twig',
            [
                'editTypeForm' => $editTypeForm->createView(),
            ]
        );
    }

    /**
     * Удаление типа
     *
     * @param Request $request
     * @param int $id - id типа
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/products/types/{id}/remove", name="product_type_remove")
     */
    public function typeRemove(Request $request, int $id)
    {
        $type = $this->getDoctrine()->getRepository(SupplierProductType::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($type);

        try {
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Тип удален!'
            );
        } catch (\Exception $e) {
            $this->addFlash(
                'warning',
                'Тип используется!'
            );
        }

        return $this->redirectToRoute('product_type_list');
    }

    /**
     * Страница товаров
     *
     * @Route("/products", name="product_list")
     */
    public function productList(Request $request)
    {
        $products = $this->getDoctrine()->getRepository(SupplierProduct::class)->findAll();

        $jsonCart = $request->cookies->get('cart');
        $cart = !empty($jsonCart) ? json_decode($jsonCart, true) : [];

        return $this->render(
            'product/list.html.twig',
            [
                'products' => $products,
                'cart' => $cart
            ]
        );
    }

}