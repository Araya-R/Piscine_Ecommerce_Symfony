<?php

namespace App\Controller\guest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{

    #[Route("/products", name: "products",)]
    public function DisplayProducts(ProductRepository $productRepository): Response
    {
        $products =  $productRepository->findby(['isPublished' => true]);
        return $this->render('guest/product/list-products.html.twig', ['products' => $products]);
    }

    #[Route("/detail-product/{id}", name: "detail-product", methods: ["GET"])]
    public function DisplayProduct(int $id, ProductRepository $productRepository)
    {

        $product = $productRepository->findOneById($id);

        if (!$product) {
            $this->addFlash('error', 'Produit introuvable');
            return $this->redirectToRoute('404');
        }
        return $this->render('guest/product/detail-product.html.twig', ['product' => $product]);
    }

    #[Route("/search-product", name: "product-search-results", methods: ["GET"])]
    public function DisplaySearchResuts(Request $request, productRepository $productRepository): Response
    {
        $search = $request->query->get('search');
        if(!$search){
            $this->addFlash('error', 'Veuillez entrer un mot clé');
            return $this->redirectToRoute('home');
        }
        $productsfound = $productRepository->findBySearch($search);
        if (empty($productsfound)) {
            $this->addFlash('error', 'Aucun produit trouvé');
            return $this->redirectToRoute('404');
        }
        
        return $this->render('guest/product/search-results.html.twig', ['productsfound' => $productsfound, 'search' => $search]);
    }
}
