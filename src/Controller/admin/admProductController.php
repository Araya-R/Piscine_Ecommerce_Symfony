<?php

namespace App\Controller\admin;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
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

            try {
                $product = new Product($title, $description, $price, $isPublished, $category);
                $entityManager->persist($product);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur:' . $e->getMessage());
            }
        }
        $categories = $categoryRepository->findAll();
        return $this->render('admin/product/admCreateProduct.html.twig', ['categories' => $categories]);
    }

    #[Route('/admin/list-products', name: "admin-list-products")]
    public function DisplayProducts(ProductRepository $productRepository)
    {

        $products = $productRepository->findAll();
        return $this->render('admin/product/list-products.html.twig', ['products' => $products]);
    }

    #[Route('/admin/delete-product/{id}', name: "admin-delete-product")]
    public function DeleteProduct($id, ProductRepository $productRepository, EntityManagerInterface $entityManager)
    {

        $product = $productRepository->findOneById($id);

        $entityManager->remove($product);
        $entityManager->flush();

        $this->addFlash('success', 'Produit supprimé');
        return $this->redirectToRoute('admin-list-products');
    }

    #[Route('/admin/update-product/{id}', name: "admin-update-product")]
    public function UpdateProduct($id, ProductRepository $productRepository, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, Request $request)
    {

        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException("Produit avec l'ID $id introuvable.");
        }
        $categories = $categoryRepository->findAll();

        if ($request->isMethod("POST")) {
            $title = $request->request->get('title');
            $description = $request->request->get('description');
            $price = $request->request->get('price');
            $isPublished = $request->request->get('published') === 'on' ? true : false;
            $categoryId = $request->request->get('category-id');

            $category = $categoryRepository->find($categoryId);

            if (!$category) {
                $this->addFlash('error', 'Catégorie invalide');
            } else try {

                $product->update($title, $description, $price, $isPublished, $category);
                $entityManager->flush();
                $this->addFlash('success', 'Produit mis à jour avec succès');

                return $this->redirectToRoute('admin-list-products');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur:' . $e->getMessage());
            }
        }

        return $this->render('admin/product/update-product.html.twig', ['categories' => $categories, 'product' => $product]);
    }
}
