<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findby(['category' => null]),
        ]);
    }

    /**
     * @Route("/first", name="category_indexFirst", methods={"GET"})
     */
    public function indexFirst(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/indexFirst.html.twig', [
            'categories' => $categoryRepository->findby(['category' => null]),
        ]);
    }
    /**
     * @Route("/new", name="category_new", methods={"GET","POST"})
     */
    public function new(Request $request, Category $category): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

//            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/edit.html.twig', [
//            'categories' => $categoryRepository->findByCategory(NULL),
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="category_delete", methods={"POST"})
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }
        if ($category->getCategory()) {
            return $this->redirectToRoute('category_edit', ['id' => $category->getId()]);
        }
        return $this->redirectToRoute('category_index');
    }

    /**
     * @Route("/{id}/modal-new-category", priority=1, name="category_modal_new")
     */
    public function modalAddNewCategory(Request $request, int $id, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        if (!$id) {
            $parentCategory = null;
        } else {
            $parentCategory = $categoryRepository->findOneById($id);
        }
        $category->setCategory($parentCategory);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            $referer = $request->headers->get('referer') ?? "/";
            return $this->redirect($referer);
        }
        return $this->render('category/modal-new-category.html.twig', [
            'category' => $parentCategory,
            'form' => $form->createView()
        ]);
    }
}
