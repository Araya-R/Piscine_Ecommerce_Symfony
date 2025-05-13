<?php 

namespace App\Controller\guest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;


class CategoryController extends AbstractController{

    #[Route("/categories", name:"categories", methods: ["GET"])]
    public function DisplayCategories(CategoryRepository $categoryRepository): Response{
       $categories =  $categoryRepository->findAll();
        return $this->render('guest/category/list-categories.html.twig', ['categories'=>$categories]);
    }

    #[Route("/detail-category/{id}", name:"detail-category", methods: ["GET"])]
    public function DisplayCategory(int $id, CategoryRepository $categoryRepository){
        $category=$categoryRepository->findOneById($id);
        if(!$category){
            $this->addFlash('error', 'Catégorie introuvable');
            return $this->redirectToRoute('404');
        }
        return $this->render('guest/category/detail-category.html.twig', ['category'=>$category]);
    }
}