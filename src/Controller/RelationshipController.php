<?php

namespace App\Controller;

use App\Entity\Relationship;
use App\Form\RelationshipType;
use App\Repository\RelationshipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/relationship')]
class RelationshipController extends AbstractController
{
    #[Route('/', name: 'app_relationship_index', methods: ['GET'])]
    public function index(RelationshipRepository $relationshipRepository): Response
    {
        return $this->render('relationship/index.html.twig', [
            'relationships' => $relationshipRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_relationship_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RelationshipRepository $relationshipRepository): Response
    {
        $relationship = new Relationship();
        $form = $this->createForm(RelationshipType::class, $relationship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $relationshipRepository->add($relationship, true);

            return $this->redirectToRoute('app_relationship_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('relationship/new.html.twig', [
            'relationship' => $relationship,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_relationship_show', methods: ['GET'])]
    public function show(Relationship $relationship): Response
    {
        return $this->render('relationship/show.html.twig', [
            'relationship' => $relationship,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_relationship_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Relationship $relationship, RelationshipRepository $relationshipRepository): Response
    {
        $form = $this->createForm(RelationshipType::class, $relationship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $relationshipRepository->add($relationship, true);

            return $this->redirectToRoute('app_relationship_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('relationship/edit.html.twig', [
            'relationship' => $relationship,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_relationship_delete', methods: ['POST'])]
    public function delete(Request $request, Relationship $relationship, RelationshipRepository $relationshipRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$relationship->getId(), $request->request->get('_token'))) {
            $relationshipRepository->remove($relationship, true);
        }

        return $this->redirectToRoute('app_relationship_index', [], Response::HTTP_SEE_OTHER);
    }
}
