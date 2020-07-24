<?php

namespace App\Controller;

use App\Entity\Supplier;
use App\Entity\SupplierProduct;
use App\Entity\SupplierProductType;
use App\Entity\SupplierRegion;
use App\Entity\SupplierStaffer;
use App\Form\AddProductTypeFormType;
use App\Form\AddSupplierFormType;
use App\Form\AddSupplierProductFormType;
use App\Form\AddSupplierRegionFormType;
use App\Form\AddSupplierStufferFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MainController extends AbstractController
{
    /**
     * Главная
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        return $this->redirect('/login');
    }

    /**
     * Страница поставщиков
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/suppliers", name="supplier_list")
     */
    public function supplierList(Request $request, ValidatorInterface $validator)
    {
        //$supplier = new Supplier();

      //  $supplierLast = $this->getDoctrine()->getRepository(Supplier::class)->findOneBy(['id' => 2]);
        $supplierLast = $this->getDoctrine()->getRepository(Supplier::class)->findLast();
        $supplier = clone $supplierLast;
        $addSupplierForm = $this->createForm(AddSupplierFormType::class, $supplier);
        $addSupplierForm->handleRequest($request);


        if ($addSupplierForm->isSubmitted()) {
            $errors = $validator->validate($supplier);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->addFlash('warning', $error->getMessage());
                }
            } else {
                $supplier = $addSupplierForm->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($supplier);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Поставщик добавлен!'
                );
            }
        }

        $suppliers = $this->getDoctrine()->getRepository(Supplier::class)->findAll();

        return $this->render(
            'supplier/list.html.twig',
            [
                'addSupplierForm' => $addSupplierForm->createView(),
                'suppliers' => $suppliers
            ]
        );
    }

    /**
     * Страница редактирования поставщика
     *
     * @param Request $request
     * @param int $id - id поставщика
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/suppliers/{id}/edit", name="supplier_edit")
     */
    public function supplierEdit(Request $request, int $id)
    {
        $supplier = $this->getDoctrine()->getRepository(Supplier::class)->find($id);
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
            'supplier/edit.html.twig',
            [
                'editSupplierForm' => $editSupplierForm->createView(),
                'supplier' => $supplier
            ]
        );
    }

    /**
     * Удаление поставщика
     *
     * @param Request $request
     * @param int $id - id поставщика
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/suppliers/{id}/remove", name="supplier_remove")
     */
    public function supplierRemove(Request $request, int $id)
    {
        $supplier = $this->getDoctrine()->getRepository(Supplier::class)->find($id);

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
     * @param Request $request
     * @param int $id - id поставщика
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/suppliers/{id}", name="supplier_view")
     */
    public function suppliesView(Request $request, int $id)
    {
        $supplier = $this->getDoctrine()->getRepository(Supplier::class)->find($id);

        if (!$supplier) {
            throw $this->createNotFoundException('The product does not exist');
        }

        $supplierStuffer = new SupplierStaffer();
        $addSupplierStufferForm = $this->createForm(AddSupplierStufferFormType::class, $supplierStuffer);
        $addSupplierStufferForm->handleRequest($request);

        if ($addSupplierStufferForm->isSubmitted() && $addSupplierStufferForm->isValid()) {
            $supplierStuffer = $addSupplierStufferForm->getData();
            $supplier->addStaffer($supplierStuffer);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplier);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Контактное лицо добавлено!'
            );
        }

        $supplierProduct = new SupplierProduct();
        $addSupplierProductForm = $this->createForm(AddSupplierProductFormType::class, $supplierProduct);
        $addSupplierProductForm->handleRequest($request);

        if ($addSupplierProductForm->isSubmitted() && $addSupplierProductForm->isValid()) {
            $supplier->addProduct($supplierProduct);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplier);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Товар добавлен!'
            );
        }

        return $this->render(
            'supplier/view.html.twig',
            [
                'supplier' => $supplier,
                'products' => $supplier->getProducts(),
                'addSupplierStufferForm' => $addSupplierStufferForm->createView(),
                'addSupplierProductForm' => $addSupplierProductForm->createView(),
            ]
        );
    }

    /**
     * Страница редактирования контактного лица
     *
     * @param Request $request
     * @param int $id - id контактного лица
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/suppliers/{supplierId}/staffer/{stafferId}/edit", name="supplier_staffer_edit")
     */
    public function supplierStafferEdit(Request $request, int $supplierId, int $stafferId)
    {
        $supplier = $this->getDoctrine()->getRepository(Supplier::class)->find($supplierId);
        $staffer = $supplier->getStaffer($stafferId);

        $editSupplierStafferForm = $this->createForm(AddSupplierStufferFormType::class, $staffer);
        $editSupplierStafferForm->handleRequest($request);

        if ($editSupplierStafferForm->isSubmitted() && $editSupplierStafferForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplier);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Контактное лицо изменено!'
            );
            return $this->redirectToRoute('supplier_view', [
                'id' => $supplierId
            ]);
        }

        return $this->render(
            'supplier/staffer/edit.html.twig',
            [
                'editSupplierStafferForm' => $editSupplierStafferForm->createView(),
                'supplier' => $supplier,
                'staffer' => $staffer,
            ]
        );
    }

    /**
     * Удаление контактного лица
     *
     * @param Request $request
     * @param int $id - id контактного лица
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/staffer/{id]/remove", name="supplier_staffer_remove")
     */
    public function supplierStafferRemove(Request $request, int $id)
    {
        $staffer = $this->getDoctrine()->getRepository(SupplierStaffer::class)->find($id);

        $supplier = $staffer->getSupplier();
        $supplier->removeStaffer($staffer);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($supplier);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Контактное лицо удалено!'
        );

        return $this->redirectToRoute('supplier_view', [
            'id' => $supplier->getId()
        ]);
    }
}