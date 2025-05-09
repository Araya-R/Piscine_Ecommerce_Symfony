<?php

namespace App\Controller\admin;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdmProductController extends AbstractController
{

    #[Route('/admin/create-product', name: "admin-create-product")]
    public function CreateProduct(Request $request, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {

        if ($request->isMethod("POST")) {
            $title = $request->request->get('title');
            $description = $request->request->get('description');
            $price = $request->request->get('price');
            $isPublished = $request->request->get('published') === 'on' ? true : false;

            $categoryId = $request->request->get('category-id');
            $category = $categoryRepository->find($categoryId);

            try{
                $product = new Product($title, $description, $price, $isPublished, $category);
                $entityManager->persist($product);
                $entityManager->flush();
            }catch(\Exception $e){
                $this->addFlash('error', 'Erreur:' . $e->getMessage() );
            }
            
            
        }
        $categories = $categoryRepository->findAll();
        return $this->render('admin/product/admCreateProduct.html.twig', ['categories' => $categories]);
    }
}
