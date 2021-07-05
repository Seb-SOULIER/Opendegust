<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     * @IsGranted("ROLE_PROVIDER")
     */
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $product->setProvider($this->getUser());
            $categories = $request->get('categories');
            foreach ($categories as $categoryId) {
                $category = $categoryRepository->find($categoryId);
                $product->setCategory($category);
            }
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'categoriesDrink' => $categoryRepository->findby(['name' => 'Boisson']),
            'categoriesFood' => $categoryRepository->findby(['name' => "Gastronomie"]),
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        $categoryProduct = $product->getCategory();

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setProvider($this->getUser());
            $product->setCategory($categoryRepository->findOneBy(['id' => $request->request->get('categories')]));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'categoriesDrink' => $categoryRepository->findby(['name' => "Boisson"]),
            'categoriesFood' => $categoryRepository->findby(['name' => "Gastronomie"]),
            'categoryProduct' => $categoryProduct
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }
        return $this->redirectToRoute('product_index');
    }

    private function Category($get)
    {
    }
}
