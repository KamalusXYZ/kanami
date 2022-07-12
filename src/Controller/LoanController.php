<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Form\LoanType;
use App\Repository\FamilyRepository;
use App\Repository\ItemRepository;
use App\Repository\LoanRepository;
use App\Repository\MemberRepository;
use App\Repository\RelationshipRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/loan')]
class LoanController extends AbstractController
{
    #[Route('/', name: 'app_loan_index', methods: ['GET'])]
    public function index(LoanRepository $loanRepository): Response
    {
        return $this->render('loan/index.html.twig', [
            'loans' => $loanRepository->findAll(),
        ]);
    }

    #[Route('searchfamily/{idItem}', name: 'app_loan_show', methods: ['GET', 'POST'])]
    public function show(EntityManagerInterface $em, Request $request, ItemRepository $itemRepository, $idItem): Response
    {

        $resultsItem = '';
        $searchWord = $request->get("word");
        $item = $itemRepository->find($idItem);


        $qb = $em->createQueryBuilder()
            ->select('m')
            ->from('App:Member', 'm')
            ->where('m.lastName LIKE :key')
            ->setParameter('key', '%' . $searchWord . '%');

        $query = $qb->getQuery();

        $resultsFamily = $query->execute();

        return $this->render('loan/show.html.twig', [

            'controller_name' => 'LoanController',
            'searchWord' => $searchWord,
            'resultsFamily' => $resultsFamily,
            'item' => $item,

        ]);
    }

    #[Route('/new/item/{idItem}/family/{idMember}', name: 'app_loan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FamilyRepository $familyRepository, RelationshipRepository $relationshipRepository, ItemRepository $itemRepository, MemberRepository $memberRepository, LoanRepository $loanRepository, $idItem, $idMember): Response
    {
        $item = $itemRepository->find($idItem);
        $member = $memberRepository->find($idMember);

        $relation = $relationshipRepository->findOneBy(['member' => $idMember]);
        $family = $relation->getFamily();

        $dateTime = date_create("now");
        $backDateTime = new DateTime();
        $backDateTime->add(new \DateInterval('P15D')); // La date de 15 jour de la date interval a été inscrite en dur, une fois le programme avancé elle sera recupéré dynamiquement dans la propriété max_duration_loan_day de la class ToyLibrary.

        $loan = new Loan();
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $loan->setCompletenessReturn(1);
            $loan->setStartDateTime($dateTime);
            $loan->setDatePreviewBack($backDateTime);
            $loan->setItem($item);
            $loan->setFamily($family);
            $family->setMaxLoanSimultaneous($family->getMaxLoanSimultaneous() - 1);
            $item->setAvailable(0);
            $loanRepository->add($loan, true);
            $this->addFlash('success', 'Prêt effectué.');

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('loan/new.html.twig', [
            'loan' => $loan,
            'form' => $form,
            'idItem' => $idItem,
            'item' => $item,
            'member' => $member,
            'family' => $family,


        ]);
    }

    #[Route('/return/item/{idItem}', name: 'app_loan_return', methods: ['GET', 'POST'])]
    public function loanReturn(Request $request, FamilyRepository $familyRepository, ItemRepository $itemRepository, LoanRepository $loanRepository, $idItem): Response
    {

        $item = $itemRepository->find($idItem);
        $arrayLoan = $loanRepository->findBy(array('item' => $idItem, 'effectReturnDateTime' => null));
        $loan = $arrayLoan[0];

        $family = $loan->getFamily();

        $form = $this->createFormBuilder($loan)
            ->add('completenessReturn', CheckboxType::class, ["label" => "Complet?", 'required' => false])
            ->add('returnComment', TextareaType::class, ['label' => 'Commentaire (optionnel)'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $loan->setEffectReturnDateTime(date_create("now"));
            $family->setMaxLoanSimultaneous($family->getMaxLoanSimultaneous() + 1);

            if ($loan->isCompletenessReturn() == 0) {

                $item->setCompleteness(0);
                $item->setAvailable(0);
                $family->setIncompleteReturnNb($family->getIncompleteReturnNb() + 1);
                $family->setIncompleteReturn(1);
                $family->setBlocked(1);
                $item->setAvailable(0);

                $loanRepository->add($loan, true);
                $familyRepository->add($family, true);
                $itemRepository->add($item, true);
                $this->addFlash('warning', 'Retour incomplet.');
                return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);

            }
            $item->setCompleteness(1);
            $item->setAvailable(1);

            $loanRepository->add($loan, true);
            $familyRepository->add($family, true);
            $itemRepository->add($item, true);
            $this->addFlash('success', 'Retour effectué.');

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);

        }

        return $this->renderForm('loan/show_return.html.twig', ['loan' => $loan,
            'form' => $form,
            'idItem' => $idItem,
            'item' => $item,
            'family' => $family,]);

    }

    #[
        Route('/{id}/edit', name: 'app_loan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Loan $loan, LoanRepository $loanRepository): Response
    {
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loanRepository->add($loan, true);

            return $this->redirectToRoute('app_loan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('loan/edit.html.twig', [
            'loan' => $loan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_loan_delete', methods: ['POST'])]
    public function delete(Request $request, Loan $loan, LoanRepository $loanRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $loan->getId(), $request->request->get('_token'))) {
            $loanRepository->remove($loan, true);
        }

        return $this->redirectToRoute('app_loan_index', [], Response::HTTP_SEE_OTHER);
    }
}
