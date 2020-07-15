<?php

namespace App\Controller;

use App\Entity\Supplier;
use App\Form\AddSupplierFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        return $this->render(
            'base.html.twig',
            [

            ]
        );
    }

    /**
     * Страница поставщиков
     *
     * @Route("/suppliers", name="supplier_list")
     */
    public function supplierList(Request $request)
    {
        $supplier = new Supplier();
        $addSupplierForm = $this->createForm(AddSupplierFormType::class, $supplier);
        $addSupplierForm->handleRequest($request);

        if ($addSupplierForm->isSubmitted() && $addSupplierForm->isValid()) {
            $supplier = $addSupplierForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplier);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Поставщик добавлен!'
            );
        }

        $suppliers = $this->getDoctrine()->getRepository(Supplier::class)->findAll();

        return $this->render(
            'supplier_list.html.twig',
            [
                'addSupplierForm' => $addSupplierForm->createView(),
                'suppliers' => $suppliers
            ]
        );
    }

    /**
     * Страница редактирования поставщика
     *
     * @Route("/suppliers/{id}/edit", name="supplier_edit")
     */
    public function supplierEdit(Request $request, int $id)
    {
        $supplier =  $this->getDoctrine()->getRepository(Supplier::class)->find($id);
        $editSupplierForm = $this->createForm(AddSupplierFormType::class, $supplier);
        $editSupplierForm->handleRequest($request);

        if ($editSupplierForm->isSubmitted() && $editSupplierForm->isValid()) {
            $supplier = $editSupplierForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplier);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Поставщик изменен!'
            );
            return $this->redirectToRoute('supplier_view', [
                'id' => $id
            ]);
        }

        return $this->render(
            'supplier_edit.html.twig',
            [
                'editSupplierForm' => $editSupplierForm->createView(),
                'supplier' => $supplier
            ]
        );
    }

    /**
     * Удаление поставщика
     *
     * @Route("/suppliers/{id}/delete", name="supplier_delete")
     */
    public function supplierRemove(Request $request, int $id)
    {
        $supplier =  $this->getDoctrine()->getRepository(Supplier::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($supplier);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Поставщик удален!'
        );

        return $this->redirectToRoute('supplier_list');
    }

    /**
     * Страница поставщика
     *
     * @Route("/suppliers/{id}", name="supplier_view")
     */
    public function suppliesView(Request $requestб, int $id)
    {
        $supplier = $this->getDoctrine()->getRepository(Supplier::class)->find($id);

        if (!$supplier) {
            throw $this->createNotFoundException('The product does not exist');
        }

        return $this->render(
            'supplier_view.html.twig',
            [
                'supplier' => $supplier
            ]
        );
    }

    /**
     * Страница товаров
     *
     * @Route("/products", name="suppliers_products_list")
     */
    public function productList(Request $request)
    {
        return $this->render(
            'base.html.twig',
            [

            ]
        );
    }
}