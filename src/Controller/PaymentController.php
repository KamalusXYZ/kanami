<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Form\PaymentType;
use App\Repository\FamilyRepository;
use App\Repository\MemberRepository;
use App\Repository\PaymentRepository;
use App\Repository\RelationshipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment')]
class PaymentController extends AbstractController
{
    #[Route('/', name: 'app_payment_index', methods: ['GET'])]
    public function index(PaymentRepository $paymentRepository): Response
    {
        return $this->render('payment/index.html.twig', [
            'payments' => $paymentRepository->findAll(),
        ]);
    }

    #[Route('/new/{idFamily}/', name: 'app_payment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RelationshipRepository $relationshipRepository, PaymentRepository $paymentRepository, FamilyRepository $familyRepository, $idFamily): Response
    {

        $idFamily = $request->get('idFamily');
        $idMember = $request->get('idMember');
        $family = $familyRepository->find($idFamily);


        $nbMember = $family->getRelationships()->count();


        $payment = new Payment();

        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);
        $dateTime = date_create("now");


        if ($form->isSubmitted() && $form->isValid()) {

            $payment->setPaymentDate($dateTime);
            $payment->setFamily($family);


            $paymentKind = $payment->getPaymentKind();
            $paymentAmount = $payment->getPaymentAmount();

            if ($paymentKind != 'aucun paiement' && $paymentAmount > 20) {
                $this->addFlash('success', 'Paiement de la cotisation complétée.');
                $family->setPaymentOk(1); // 20 est le prix choisit en attendant , celui ci sera fixé dynamiquement quand la ludotheque sera créée, et que le champs subscription_price_month (x12) sera renseigné.

            } else {
                $this->addFlash('warning', 'Paiement de la cotisation mis en suspens.');
            }
            $family->setMaxLoanSimultaneous($nbMember * 2); // 2 est le nombre choisit de pret par membre, en attendant que celui ci soit determiné dynamiquement dans la ludotheque dans le champs max_loan_simult_user + attention a verifier si celui ci ne depasse pas le champs max_loan_simult_family
            $paymentRepository->add($payment, true);

            return $this->redirectToRoute('app_payment_new_deposit', ['idMember' => $idMember, 'idFamily' => $idFamily], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment/new.html.twig', [
            'payment' => $payment,
            'form' => $form,
            'idFamily' => $idFamily,
            'idMember' => $idMember
        ]);
    }

    #[Route('/new_deposit/{idFamily}/', name: 'app_payment_new_deposit', methods: ['GET', 'POST'])]
    public function newDeposit(Request $request, PaymentRepository $paymentRepository, FamilyRepository $familyRepository, $idFamily, MemberRepository $memberRepository): Response
    {

        $idFamily = $request->get('idFamily');
        $payment = new Payment();

        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);
        $dateTime = date_create("now");


        $idMember = $request->get('idMember');
        $member = $memberRepository->find('idMember');


        $family = $familyRepository->find($idFamily);


        if ($form->isSubmitted() && $form->isValid()) {

            if ($payment->getPaymentAmount() > 50){

                $family->setDeposit(1); // 50  est determiné en attendant qu'il soit dynamiquement crée dans ludotheque avec la propriete deposit_amount
                $this->addFlash('success', 'Paiement du dépot de garantie completé.');

            }else{
                $this->addFlash('warning', 'Paiement du dépot de garantie mis en suspens.');

            }


            if ($payment->getPaymentComment()) $family->setDepositInformation($payment->getPaymentComment());

            $payment->setPaymentDate($dateTime);
            $payment->setFamily($family);
            $paymentOK = $payment->getId();


            if ($paymentOK) $family->setPaymentOk(1);


            $paymentRepository->add($payment, true);

            return $this->redirectToRoute('app_family_show', ['idFamily' => $idFamily], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment/new_deposit.html.twig', [
            'payment' => $payment,
            'form' => $form,
            'idFamily' => $idFamily,
            'family' => $family

        ]);
    }


    #[Route('/{id}', name: 'app_payment_show', methods: ['GET'])]
    public function show(Payment $payment): Response
    {
        return $this->render('payment/show.html.twig', [
            'payment' => $payment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_payment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Payment $payment, PaymentRepository $paymentRepository): Response
    {
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paymentRepository->add($payment, true);

            return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment/edit.html.twig', [
            'payment' => $payment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payment_delete', methods: ['POST'])]
    public function delete(Request $request, Payment $payment, PaymentRepository $paymentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $payment->getId(), $request->request->get('_token'))) {
            $paymentRepository->remove($payment, true);
        }

        return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
    }
}
