<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/category", name="category")
     */
    public function index(): Response
    {
        $categories = $this->em->getRepository(Category::class)->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/add", name="add_category")
     */
    public function add(Request $request): Response
    {
        $category = new Category;

        $addCategoryForm = $this->createForm(CategoryType::class, $category);

        $addCategoryForm->handleRequest($request);

        if($addCategoryForm->isSubmitted() && $addCategoryForm->isValid()) {

            $category = $addCategoryForm->getData();

            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('category');
        }

        return $this->render('category/add.html.twig', [
            'add_category_form' => $addCategoryForm->createView()
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="delete_category")
     */
    public function delete(Category $id): Response
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('category');
    }

    /**
     * @Route("/category/modify/{id}", name="modify_category")
     */
    public function modify(Category $id, Request $request): Response
    {
        //$category = $this->em->getRepository(Category::class)->findById($id);
        $updateCategoryForm = $this->createForm(CategoryType::class, $id);

        $updateCategoryForm->handleRequest($request);

        if ($updateCategoryForm->isSubmitted() && $updateCategoryForm->isValid()) {
            $this->em->flush();
        }

        return $this->render('category/modify.html.twig', [
            'modify_category_form' => $updateCategoryForm->createView()
        ]);
    }
}
