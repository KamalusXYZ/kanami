<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Form\PaymentType;
use App\Repository\FamilyRepository;
use App\Repository\MemberRepository;
use App\Repository\PaymentRepository;
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
    public function new(Request $request, PaymentRepository $paymentRepository, FamilyRepository $familyRepository, $idFamily ): Response
    {

        $idFamily = $request->get('idFamily');
        $idMember = $request->get('idMember');

        $payment = new Payment();

        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);
        $dateTime = date_create("now");

        $family = $familyRepository->find($idFamily);

        if ($form->isSubmitted() && $form->isValid()) {

            $payment->setPaymentDate($dateTime);
            $payment->setFamily($family);
            $paymentOK = $payment->getId();
            if($paymentOK) $family->setPaymentOk(1);


            $paymentRepository->add($payment, true);

            return $this->redirectToRoute('app_payment_new_deposit', ['idMember'=> $idMember, 'idFamily'=> $idFamily], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment/new.html.twig', [
            'payment' => $payment,
            'form' => $form,
            'idFamily'=>$idFamily,
            'idMember'=>$idMember
        ]);
    }

    #[Route('/new_deposit/{idFamily}/', name: 'app_payment_new_deposit', methods: ['GET', 'POST'])]
    public function newDeposit(Request $request, PaymentRepository $paymentRepository, FamilyRepository $familyRepository, $idFamily, MemberRepository $memberRepository ): Response
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

            $payment->setPaymentDate($dateTime);
            $payment->setFamily($family);
            $paymentOK = $payment->getId();
            if($paymentOK) $family->setPaymentOk(1);


            $paymentRepository->add($payment, true);

            return $this->redirectToRoute('app_main', ['idFamily'=> $idFamily], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment/new.html.twig', [
            'payment' => $payment,
            'form' => $form,
            'idFamily'=>$idFamily,
            'family'=>$family

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
        if ($this->isCsrfTokenValid('delete'.$payment->getId(), $request->request->get('_token'))) {
            $paymentRepository->remove($payment, true);
        }

        return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
    }
}
