<?php

namespace App\Controller\admin;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class admProductController extends AbstractController{

    #[Route('/admin/create-product', name: "admin-create-product")]
    public function CreateProduct (Request $request,CategoryRepository $categoryRepository){

        if($request ->isMethod("POST")){
            $title = $request->request->get('title');
            $description= $request->request->get('description');
            $price=$request->request->get('price');
            $categoryId = $request->request->get('category-id');
            $isPublished= $request->request->get('published') === 'on' ? true : false;

       }
        $categories=$categoryRepository->findAll();
        return $this->render('admin/product/admCreateProduct.html.twig', ['categories' =>$categories]);
    }
}