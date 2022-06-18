<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\FamilyRepository;
use App\Repository\MemberRepository;
use App\Repository\RelationshipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

#[Route('/member')]
class MemberController extends AbstractController
{
    #[Route('/', name: 'app_member_index', methods: ['GET'])]
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->render('member/index.html.twig', [
            'members' => $memberRepository->findAll(),
        ]);
    }

    #[Route('/new/{idFamily}', name: 'app_member_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MemberRepository $memberRepository, FamilyRepository $familyRepository): Response
    {
        $member = new Member();
        $idMember = $member->getId();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);
        $idFamily = $request->get('idFamily');
        $family = $familyRepository->find($idFamily);

        if ($form->isSubmitted() && $form->isValid()) {

            $nbMember = $family->getRelationships()->count();
            $family->setMaxLoanSimultaneous($nbMember * 2);
            $memberRepository->add($member, true);

            return $this->redirectToRoute('app_relationship_new', ['idMember' => $member->getId(), 'idFamily' => $idFamily, 'member' => $member, 'family' => $family], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('member/new.html.twig', [
            'member' => $member,
            'form' => $form,
            'family' => $family,
            'idFamily' => $idFamily,
            'idMember' => $idMember
        ]);
    }

    #[Route('/new-in-existing/{idFamily}', name: 'app_member_new_in_existing', methods: ['GET', 'POST'])]
    public function newInExisting(Request $request, MemberRepository $memberRepository, FamilyRepository $familyRepository, RelationshipRepository $relationshipRepository): Response
    {
        $member = new Member();
        $idMember = $member->getId();
        $idFamily = $request->get('idFamily');
        $family = $familyRepository->find($idFamily);

        $form = $this->createFormBuilder($member)
            ->add('firstName', TextType::class, ['label' => 'Prénom', 'required' => true])
            ->add('lastName', TextType::class, ['label' => 'Nom', 'required' => true])
            ->add('birthDay', DateType::class, ['label' => 'Date de naissance', 'required' => true])
            ->add('phone', TelType::class, ['label' => 'Numéro de tél.', 'required' => false])
            ->add('email', EmailType::class, ['label' => 'Email', 'required' => false])
            ->add('address', TextType::class, ['label' => 'Adresse', 'required' => false])
            ->add('zipCode', TextType::class, ["label" => "Code Postal: ", 'required' => false, 'attr' => ['maxlength' => 5]])
            ->add('city', TextType::class, ["label" => "Ville: ", 'required' => false])
            ->add('country', CountryType::class, ["label" => "Prénom: ", 'required' => false])
            ->add('otherAddressDetail', TextType::class, ["label" => "Prénom: ", 'required' => false])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $memberRepository->add($member, true);
            $nbMember = $family->getRelationships()->count();
            $family->setMaxLoanSimultaneous(($nbMember * 2) +2);
            $familyRepository->add($family, true);

            return $this->redirectToRoute('app_relationship_new_in_existing', ['idMember' => $member->getId(), 'idFamily' => $idFamily, 'member' => $member, 'family' => $family], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('relationship/new.html.twig', [
            'member' => $member,
            'form' => $form,
            'family' => $family,
            'idFamily' => $idFamily,
            'idMember' => $idMember
        ]);
    }


    #[Route('/new-owner/{idFamily}', name: 'app_member_new_owner', methods: ['GET', 'POST'])]
    public function newOwner(Request $request, MemberRepository $memberRepository, $idFamily, FamilyRepository $familyRepository): Response
    {

        $member = new Member();
        $firstNameMember = $member->getFirstName();
        $family = $familyRepository->find($idFamily);

        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $memberRepository->add($member, true);

            return $this->redirectToRoute('app_relationship_new_owner', ['idMember' => $member->getId(), 'idFamily' => $idFamily, 'member' => $member], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('member/new_owner.html.twig', [
            'member' => $member,
            'form' => $form,
            'family' => $family
        ]);
    }


    #[Route('/{id}', name: 'app_member_show', methods: ['GET'])]
    public function show(Member $member): Response
    {
        return $this->render('member/show.html.twig', [
            'member' => $member,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_member_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Member $member, MemberRepository $memberRepository): Response
    {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $memberRepository->add($member, true);

            return $this->redirectToRoute('app_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('member/edit.html.twig', [
            'member' => $member,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_member_delete', methods: ['POST'])]
    public function delete(Request $request,FamilyRepository $familyRepository,RelationshipRepository $relationshipRepository, Member $member, MemberRepository $memberRepository, $id): Response
    {
        $relations = $relationshipRepository->findBy(['member'=>$id]);
        $relation = '';
        foreach ($relations as $relation){
            $relation = $relation;
    }
        $idFamily = $relation->getFamily()->getId();


        if ($this->isCsrfTokenValid('delete' . $member->getId(), $request->request->get('_token'))) {
            $member->setArchive(1);
            $memberRepository->add($member,true);
        }

        return $this->redirectToRoute('app_family_show', ['idFamily'=>$idFamily], Response::HTTP_SEE_OTHER);
    }

}
