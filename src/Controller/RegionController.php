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

class RegionController extends AbstractController
{

    /**
     * Страница регионов
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/regions", name="region_list")
     */
    public function regionList(Request $request, ValidatorInterface $validator)
    {
        $region = new SupplierRegion();
        $addRegionForm = $this->createForm(AddSupplierRegionFormType::class, $region);
        $addRegionForm->handleRequest($request);

        if ($addRegionForm->isSubmitted() && $addRegionForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($region);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Регион добавлен!'
            );
        }

        $regions = $this->getDoctrine()->getRepository(SupplierRegion::class)->findAll();

        return $this->render(
            'region/list.html.twig',
            [
                'addRegionForm' => $addRegionForm->createView(),
                'regions' => $regions
            ]
        );
    }

    /**
     * Страница редактирования региона
     *
     * @param Request $request
     * @param int $id - id региона
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/regions/{id}/edit", name="region_edit")
     */
    public function regionEdit(Request $request, int $id)
    {
        $region = $this->getDoctrine()->getRepository(SupplierRegion::class)->find($id);

        $editRegionForm = $this->createForm(AddSupplierRegionFormType::class, $region);
        $editRegionForm->handleRequest($request);

        if ($editRegionForm->isSubmitted() && $editRegionForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($region);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Регион изменен!'
            );
            return $this->redirectToRoute('region_list');
        }

        return $this->render(
            'region/edit.html.twig',
            [
                'editRegionForm' => $editRegionForm->createView(),
            ]
        );
    }

    /**
     * Удаление региона
     *
     * @param Request $request
     * @param int $id - id региона
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/regions/{id}/remove", name="region_remove")
     */
    public function regionRemove(Request $request, int $id)
    {
        $region = $this->getDoctrine()->getRepository(SupplierRegion::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($region);

        try {
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Регион удален!'
            );
        } catch (\Exception $e) {
            $this->addFlash(
                'warning',
                'Регион используется!'
            );
        }

        return $this->redirectToRoute('region_list');
    }


}