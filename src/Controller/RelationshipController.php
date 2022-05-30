<?php

namespace App\Controller;

use App\Entity\Relationship;
use App\Form\RelationshipType;
use App\Repository\FamilyRepository;
use App\Repository\MemberRepository;
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

    private function manageNew(Request $request, RelationshipRepository $relationshipRepository, FamilyRepository $familyRepository, MemberRepository $memberRepository, $is_owner = 0): Response
    {
        $idFamily = $request->get('idFamily');
        $Family = $familyRepository->find(id: $idFamily);
        $idMember = $request->get('idMember');
        $member = $memberRepository->find(id: $idMember);

        $relationship = new Relationship();
        $form = $this->createForm(RelationshipType::class, $relationship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $relationship->setIsOwner($is_owner);
            $relationship->setFamily($Family);
            $relationship->setMember($member);
            $relationshipRepository->add($relationship, true);
            return $this->redirectToRoute($is_owner == 0 ? 'app_member_new' : 'app_member_new', ['idFamily' => $idFamily], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm($is_owner == 0 ? 'relationship/new.html.twig' : 'relationship/new_owner.html.twig', [
            'relationship' => $relationship,
            'form' => $form,
            'member' => $member
        ]);
    }

    #[Route('/family/{idFamily}/member/{idMember}/new_owner', name: 'app_relationship_new_owner', methods: ['GET', 'POST'])]
    public function newOwner(Request $request, RelationshipRepository $relationshipRepository, FamilyRepository $familyRepository, MemberRepository $memberRepository): Response
    {
        return $this->manageNew($request, $relationshipRepository, $familyRepository, $memberRepository, 1);
    }

    #[Route('/family/{idFamily}/member/{idMember}/new', name: 'app_relationship_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RelationshipRepository $relationshipRepository, FamilyRepository $familyRepository, MemberRepository $memberRepository): Response
    {

        return $this->manageNew($request, $relationshipRepository, $familyRepository, $memberRepository, 0);
    }

    #[Route('/family/{idFamily}/member/{idMember}/new_in_existing', name: 'app_relationship_new_in_existing', methods: ['GET', 'POST'])]
    public function newInExisting(Request $request, RelationshipRepository $relationshipRepository, FamilyRepository $familyRepository, MemberRepository $memberRepository, $is_owner = 0): Response
    {
        $idFamily = $request->get('idFamily');
        $Family = $familyRepository->find(id: $idFamily);
        $idMember = $request->get('idMember');
        $member = $memberRepository->find(id: $idMember);

        $relationship = new Relationship();
        $form = $this->createForm(RelationshipType::class, $relationship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $relationship->setIsOwner($is_owner);
            $relationship->setFamily($Family);
            $relationship->setMember($member);
            $relationshipRepository->add($relationship, true);
            return $this->redirectToRoute('app_family_show' , ['idFamily' => $idFamily], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm($is_owner == 0 ? 'relationship/new.html.twig' : 'relationship/new_owner.html.twig', [
            'relationship' => $relationship,
            'form' => $form,
            'member' => $member
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
        if ($this->isCsrfTokenValid('delete' . $relationship->getId(), $request->request->get('_token'))) {
            $relationshipRepository->remove($relationship, true);
        }

        return $this->redirectToRoute('app_relationship_index', [], Response::HTTP_SEE_OTHER);
    }
}
