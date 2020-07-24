<?php

namespace App\Controller;

use App\Entity\Supplier;
use App\Entity\SupplierProduct;
use App\Entity\SupplierProductType;
use App\Entity\SupplierRegion;
use App\Entity\SupplierStaffer;
use App\Entity\User;
use App\Form\AddProductTypeFormType;
use App\Form\AddSupplierFormType;
use App\Form\AddSupplierProductFormType;
use App\Form\AddSupplierRegionFormType;
use App\Form\AddSupplierStufferFormType;
use App\Form\AddUserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{

    /**
     * Страница регионов
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/users", name="user_list")
     */
    public function userList(Request $request, ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder)
    {

        $addUserForm = $this->createForm(AddUserFormType::class);
        $addUserForm->handleRequest($request);

        if ($addUserForm->isSubmitted() && $addUserForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = new User();
            $user->setUsername($addUserForm->get('username')->getData());
            $user->setRoles([$addUserForm->get('role')->getData()]);

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $addUserForm->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Пользователь добавлен!'
            );
        }

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render(
            'user/list.html.twig',
            [
                'addUserForm' => $addUserForm->createView(),
                'users' => $users,
                'rolesAssoc' => User::$rolesAssoc
            ]
        );
    }

    /**
     * Страница редактирования региона
     *
     * @param Request $request
     * @param int $id - id пользователя
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function userEdit(Request $request, int $id, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $editUserForm = $this->createForm(AddUserFormType::class);
        $editUserForm->handleRequest($request);

        // Если форма отправлена
        if ($editUserForm->isSubmitted() && $editUserForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $user->setUsername($editUserForm->get('username')->getData());
            $user->setRoles([$editUserForm->get('role')->getData()]);

            // Если пароль был изменен
            if (!empty($editUserForm->get('plainPassword')->getData()) && $user->getPassword() != $editUserForm->get('plainPassword')->getData()) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $editUserForm->get('plainPassword')->getData()
                    )
                );
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Пользователь изменен!'
            );
            return $this->redirectToRoute('user_list');
        } else {
            $editUserForm->get('username')->setData($user->getUsername());
            $editUserForm->get('role')->setData($user->getRoles()[0]);

            $editUserForm->get('plainPassword')->setData($user->getPassword());
        }

        return $this->render(
            'user/edit.html.twig',
            [
                'editUserForm' => $editUserForm->createView(),
            ]
        );
    }

    /**
     * Удаление региона
     *
     * @param Request $request
     * @param int $id - id пользователя
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/users/{id}/remove", name="user_remove")
     */
    public function userRemove(Request $request, int $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Пользователь удален!'
        );

        return $this->redirectToRoute('user_list');
    }


}