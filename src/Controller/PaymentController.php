<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Form\PaymentType;
use App\Repository\FamilyRepository;
use App\Repository\MemberRepository;
use App\Repository\PaymentRepository;
use App\Repository\RelationshipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/payment')]
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
            $payment->setPaymentCause("cotisation");


            $paymentKind = $payment->getPaymentKind();


            if ($paymentKind != 'aucun paiement') {
                $payment->setPaymentAmount(20);
                $this->addFlash('success', 'Paiement de la cotisation compl??t??e. Etape suivante paiement du d??pot de garantie.');
                $family->setPaymentOk(1); // 20 est le prix choisit en attendant , celui ci sera fix?? dynamiquement quand la ludotheque sera cr????e, et que le champs subscription_price_month (x12) sera renseign??.

            } else {
                $this->addFlash('warning', 'Paiement de la cotisation mis en suspens. Etape suivante paiement du d??pot de garantie.');
            }
            $family->setMaxLoanSimultaneous($nbMember * 2); // 2 est le nombre choisit de pret par membre, en attendant que celui ci soit determin?? dynamiquement dans la ludotheque dans le champs max_loan_simult_user + attention a verifier si celui ci ne depasse pas le champs max_loan_simult_family
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


        $family = $familyRepository->find($idFamily);


        if ($form->isSubmitted() && $form->isValid()) {

            $payment->setPaymentCause("dg");

            if ($payment->getPaymentKind() != 'aucun paiement') {
                $payment->setPaymentAmount(50);
                $family->setDeposit(1); // 50  est determin?? en attendant qu'il soit dynamiquement cr??e dans ludotheque avec la propriete deposit_amount
                $this->addFlash('success', 'Paiement du d??pot de garantie complet??. Nouvelle famille ajout??e');

            } else {
                $this->addFlash('warning', 'Paiement du d??pot de garantie mis en suspens. Nouvelle famille ajout??e');

            }

            // Si un commentaire sur le paiement en cours est inscrit, l'ajouter ?? la propri??t?? de la famille depositInformation.
            if ($payment->getPaymentComment()) $family->setDepositInformation($payment->getPaymentComment());

            $payment->setPaymentDate(date_create("now"));
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

    #[Route('/pay/payment{idPayment}/family{idFamily}', name: 'app_pay', methods: ['GET', 'POST'])]
    public function updatePayment(Request $request, PaymentRepository $paymentRepository, FamilyRepository $familyRepository, $idFamily, MemberRepository $memberRepository): Response
    {
        // Retrouver la famille pour y avoir acc??s dans le DOM.
        $family = $familyRepository->find($idFamily);
        // Retrouver l'impay?? et le stocker.
        $paymentIncompletes = $paymentRepository->findBy(array('family' => $idFamily, 'paymentAmount' => null, 'paymentCause' => "cotisation"));

        $paymentIncomplete = $paymentIncompletes[0];
        $paymentIncomplete->setPaymentComment("");


        $form = $this->createFormBuilder($paymentIncomplete)
            ->add('paymentKind', ChoiceType::class, [
                'choices' => [

                    'Carte bancaire' => "cb",
                    'Ch??que' => "cheque",
                    'Esp??ce' => "espece",
                    'Autre' => "autre",
                ], "label" => "Choisissez le mode de paiement: ", 'required' => true
            ])
            ->add('paymentComment', TextareaType::class, ["label" => "Commentaire: ", 'required' => false,
                'empty_data' => 'Aucun commentaire'])
            ->add('Confirmer', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paymentIncomplete->setPaymentAmount(20);
//fonctionnalit?? en attente
            // V??rifie que c'est le seul impay?? afin de remettre la dans l'entit?? family la propri??t?? paymentOk sur true & blocked sur false
//            if (count($paymentIncompletes) < 1) {
            $family->setPaymentOk(1);
            $family->setBlocked(0);
//            }


            $paymentRepository->add($paymentIncomplete, true);
            $this->addFlash('success', 'Cotisation pay??e.');
            return $this->redirectToRoute('app_family_show', ['idFamily' => $idFamily], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment/new_payment.html.twig', [
            'payment' => $paymentIncomplete,
            'form' => $form,
            'idFamily' => $idFamily,
            'family' => $family

        ]);
    }
//Fonctionnalit?? temporairement mise en attente car probl??me de compatibilit?? avec la methode au dessus,?? ??tudier
//    #[Route('/pay/payment-deposit{idPayment}/family{idFamily}', name: 'app_pay_deposit', methods: ['GET', 'POST'])]
//    public function updatePaymentDeposit(Request $request, PaymentRepository $paymentRepository, FamilyRepository $familyRepository, $idFamily): Response
//    {
//        // Retrouver la famille pour y avoir acc??s dans le DOM.
//        $family = $familyRepository->find($idFamily);
//        // Retrouver l'impay?? et le stocker.
//        $paymentIncompletes = $paymentRepository->findBy(array('family' => $idFamily, 'paymentAmount' => null, 'paymentCause' => "dg"));
//
//        $paymentIncomplete = $paymentIncompletes[0];
//
//        $paymentIncomplete->setPaymentComment("");
//
//        $form = $this->createFormBuilder($paymentIncomplete)
//            ->add('paymentKind', ChoiceType::class, [
//                'choices' => [
//
//                    'Carte bancaire' => "cb",
//                    'Ch??que' => "cheque",
//                    'Esp??ce' => "espece",
//                    'Autre' => "autre",
//                ], "label" => "Choisissez le mode de paiement: ", 'required' => true
//            ])
//            ->add('paymentComment', TextareaType::class, ["label" => "Commentaire: ", 'required' => false,
//                'empty_data' => 'Aucun commentaire'])
//            ->add('Confirmer', SubmitType::class)
//            ->getForm();
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $paymentIncomplete->setPaymentAmount(50);
//            $family->setBlocked(0);
//            $family->setPaymentOk(1);
//
//
//            $paymentRepository->add($paymentIncomplete, true);
//            $this->addFlash('success', 'D??pot de garantie pay??.');
//            return $this->redirectToRoute('app_family_show', ['idFamily' => $idFamily], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->renderForm('payment/new_payment_deposit.html.twig', [
//            'payment' => $paymentIncomplete,
//            'form' => $form,
//            'idFamily' => $idFamily,
//            'family' => $family
//
//        ]);
//    }


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
