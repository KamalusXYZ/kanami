<?php

namespace App\Controller;

use App\Entity\Family;
use App\Form\FamilyType;
use App\Repository\FamilyRepository;
use App\Repository\LoanRepository;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/family')]
class FamilyController extends AbstractController
{
    #[Route('/', name: 'app_family_index', methods: ['GET'])]
    public function index(FamilyRepository $familyRepository): Response
    {
        return $this->render('family/index.html.twig', [
            'families' => $familyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_family_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FamilyRepository $familyRepository): Response
    {

        $family = new Family();

        $form = $this->createForm(FamilyType::class, $family);

        $form->handleRequest($request);


        $dateTime = date_create("now");


        if ($form->isSubmitted() && $form->isValid()) {
            $family->setMaxLoanSimultaneous(0);
            $family->setDelayWarning(0);
            $family->setIncompleteReturn(0);
            $family->setBlocked(0);
            $family->setPaymentOk(0);
            $family->setDeposit(0);

            $family->setRegisterDate($dateTime);
            $familyRepository->add($family, true);
            $idFamily = $family->getId();


            return $this->redirectToRoute('app_member_new_owner', ['idFamily' => $idFamily], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('family/new.html.twig', [
            'family' => $family,
            'form' => $form,
        ]);
    }

    #[Route('/{idFamily}', name: 'app_family_show', methods: ['GET'])]
    public function show(Request $request, FamilyRepository $familyRepository, $idFamily): Response
    {


        $family = $familyRepository->find($idFamily);


        return $this->render('family/show.html.twig', [
            'family' => $family,
        ]);
    }

    #[Route('/{idFamily}/resolve', name: 'app_family_resolve', methods: ['GET', 'POST'])]
    public function resolve(Request $request, LoanRepository $loanRepository, PaymentRepository $paymentRepository, FamilyRepository $familyRepository, $idFamily): Response
    {
        $loan = 0;

        // recherche de la famille ayant un pret retourn?? incomplet
        $family = $familyRepository->find($idFamily);
        // recherche du pret litigieux, recuperation sous forme de tableau.
        $loansToResolve = $loanRepository->findBy(array('completenessReturn' => 0, 'family' => $idFamily));

        //Rechercher un paiement de cotisation  non ?? jour (20 represente le cout en ??? d'une cotisation ecrit en dur, le montant sera un propri??t?? de toyLibrary quand celle ??i sera mise en place.
        $incompleteContributions = $paymentRepository->findBy(array('family' => $idFamily, 'paymentCause' => "cotisation", 'paymentAmount' => null));
        //Rechercher un paiement de depot de garantie  non ?? jour (50 represente le cout en ??? d'une cotisation ecrit en dur, le montant sera un propri??t?? de toyLibrary quand celle ??i sera mise en place.
        $incompleteDeposits = $paymentRepository->findBy(array('family' => $idFamily, 'paymentCause' => "dg", 'paymentAmount' => null));




        return $this->render('family/resolve.html.twig', [
            'family' => $family,
            'idFamily' => $idFamily,
            'loanToResolve' => $loansToResolve,
            'incompleteContributions' => $incompleteContributions,
            'incompleteDeposits' => $incompleteDeposits


        ]);
    }


    #[Route('/{id}/edit', name: 'app_family_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Family $family, FamilyRepository $familyRepository): Response
    {
        $form = $this->createForm(FamilyType::class, $family);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $familyRepository->add($family, true);

            return $this->redirectToRoute('app_family_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('family/edit.html.twig', [
            'family' => $family,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_family_delete', methods: ['POST'])]
    public function delete(Request $request, Family $family, FamilyRepository $familyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $family->getId(), $request->request->get('_token'))) {
            $familyRepository->remove($family, true);
        }

        return $this->redirectToRoute('app_family_index', [], Response::HTTP_SEE_OTHER);
    }


}
