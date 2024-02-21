<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/create', name: 'create_category')]
    public function create(CategoryRepository $categoryRepository,Request $request, EntityManagerInterface $manager):Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute("app_nems");
        }

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('show_nem', ["id" => $category->getId()]);
        };
        return $this->render('nem/create_category.html.twig', [
            'form' => $form->createView(),
            'category' => $categoryRepository->findAll()
        ]);
    }
}
