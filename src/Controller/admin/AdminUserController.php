<?php

namespace App\Controller\admin;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class AdminUserController extends AbstractController
{
    #[Route('/admin/create-user', name: 'admin-create-user')]
    public function CreateAdmin(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response{

        //si le formulaire a été soumis en POST
        if ($request->isMethod("POST")) {
           
            //récupération des données du formulaire HTML
            $password = $request->request->get('password');
            $email = $request->request->get('email');

            //création d'un nouvel utilisateur
            $user = new User();
            //on set le mot de passe
            $user->setEmail($email);
            

            //on hash le mot de passe
            $passwordHashed = $passwordHasher->hashPassword($user, $password);
            //Enregistre le mdp sécurisé
            $user->setPassword($passwordHashed);

            //on set le role
            $user->setRoles(['ROLE_ADMIN']);

            //enregistrement de l'utilisateur dans la BDD
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Nouvel administrateur créé avec succès !');

            //redirection vers la page de création d'utilisateur
            return $this->redirectToRoute('admin-create-user');

            // 2eme méthode:
            // public function createAdmin($email, $passwordHashed) {
            //     $this->email = $email;
            //     $this->password = $passwordHashed;
            //     $this->roles = ['ROLE_ADMIN'];
            // }
            // $user->createAdmin($email, $passwordHashed);



        }
        //si le formulaire n'a pas été soumis, on affiche le formulaire
        return $this->render('/admin/user/create-user.html.twig');
    }
}