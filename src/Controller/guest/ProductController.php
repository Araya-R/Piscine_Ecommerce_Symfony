<?php 

namespace App\Controller\guest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;

class ProductController extends AbstractController{

    #[Route("/products", name:"products")]
    public function DisplayProducts(ProductRepository $productRepository){
       $products =  $productRepository->findby(['isPublished'=> true]);
        return $this->render('guest/product/list-products.html.twig', ['products'=>$products]);
    }

    #[Route("/detail-product/{id}", name:"detail-product")]
    public function DisplayProduct($id, ProductRepository $productRepository){

        $product=$productRepository->findOneById($id);

        if(!$product){
            $this->addFlash('error', 'Produit introuvable');
            return $this->redirectToRoute('404');
        }
        return $this->render('guest/product/detail-product.html.twig', ['product'=>$product]);
    }
}