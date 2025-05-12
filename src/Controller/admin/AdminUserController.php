<?php

namespace App\Controller\admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class AdminUserController extends AbstractController
{
    #[Route('/admin/create-user', name: 'admin-create-user')]
    public function CreateAdmin(Request $request, UserPasswordHasherInterface $passwordHasher){

        if ($request->isMethod("POST")) {
           
            $password = $request->request->get('password');
            $email = $request->request->get('email');

            $user = new User();
            $passwordHashed = $passwordHasher->hashPassword($user, $password);

            dump($passwordHashed);
            dump($email);die;

        }
        return $this->render('/admin/user/create-user.html.twig');
    }
}