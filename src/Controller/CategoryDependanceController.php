<?php

namespace App\Controller;

use App\Entity\CategoryDependance;
use App\Form\CategoryDependanceType;
use App\Repository\CategoryDependanceRepository;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/catdependance')]
class CategoryDependanceController extends AbstractController
{
    #[Route('/', name: 'app_category_dependance_index', methods: ['GET'])]
    public function index(CategoryDependanceRepository $categoryDependanceRepository): Response
    {
        return $this->render('category_dependance/index.html.twig', [
            'category_dependances' => $categoryDependanceRepository->findAll(),
        ]);
    }

    #[Route('/new/{idItem}', name: 'app_category_dependance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryDependanceRepository $categoryDependanceRepository, ItemRepository $itemRepository, $idItem): Response
    {
        $item = $itemRepository->find($idItem);
        $categoryDependance = new CategoryDependance();
        $categories = $categoryDependanceRepository->findBy(['item' => $idItem]);

        $form = $this->createForm(CategoryDependanceType::class, $categoryDependance, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $item = $itemRepository->find($request->get("idItem"));
            $categoryDependance->setItem($item);

            if ($categoryDependance->getCategory() == null ){
                $this->addFlash('warning', 'Aucune catégorie , veuillez selectionner une catégorie avant de valider');
            }else{
                $this->addFlash('succes', 'Catégorie ajoutée');
            }
            $categoryDependanceRepository->add($categoryDependance, true);

            return $this->redirectToRoute('app_category_dependance_new', ['idItem' => $idItem], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_dependance/new.html.twig', [
            'category_dependance' => $categoryDependance,
            'form' => $form,
            'item' => $item,
            'categories' => $categories

        ]);
    }

    #[Route(' /{id}', name: 'app_category_dependance_show', methods: ['GET'])]
    public function show(CategoryDependance $categoryDependance): Response
    {
        return $this->render('category_dependance/show.html.twig', [
            'category_dependance' => $categoryDependance,
        ]);
    }

    #[Route(' /{id}/edit', name: 'app_category_dependance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoryDependance $categoryDependance, CategoryDependanceRepository $categoryDependanceRepository): Response
    {
        $form = $this->createForm(CategoryDependanceType::class, $categoryDependance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryDependanceRepository->add($categoryDependance, true);

            return $this->redirectToRoute('app_category_dependance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_dependance/edit.html.twig', [
            'category_dependance' => $categoryDependance,
            'form' => $form,
        ]);
    }

    #[Route(' /{id}', name: 'app_category_dependance_delete_in_creation', methods: ['POST'])]
    public function deleteInCreation(Request $request, CategoryDependance $categoryDependance, CategoryDependanceRepository $categoryDependanceRepository): Response
    {


        if ($this->isCsrfTokenValid('delete' . $categoryDependance->getId(), $request->request->get('_token'))) {
            $categoryDependanceRepository->remove($categoryDependance, true);
        }

        return $this->redirectToRoute('app_category_dependance_new', ['idItem' => $categoryDependance->getItem()->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route(' /{id}', name: 'app_category_dependance_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryDependance $categoryDependance, CategoryDependanceRepository $categoryDependanceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $categoryDependance->getId(), $request->request->get('_token'))) {
            $categoryDependanceRepository->remove($categoryDependance, true);
        }

        return $this->redirectToRoute('app_category_dependance_index', [], Response::HTTP_SEE_OTHER);
    }


}
