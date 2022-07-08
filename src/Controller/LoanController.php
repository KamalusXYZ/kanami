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

#[Route('/loan')]
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
        // Initialisation de la variable loan pour attribution mémoire.
        $loan = '';
        // Récupérer l'objet qi sera retourné grâce à son ID avec la méthod find()
        $item = $itemRepository->find($idItem);
        // Récupérer les prêts avec findBy() avec l'idItem du jeu à retourner et la prop effectReturnDateTime à null (un seul résultat peux sortir), mettre sa dans une variable.
        $arrayLoan = $loanRepository->findBy(array('item' => $idItem, 'effectReturnDateTime' => null));
        // Boucler sur le tableau retourné , et mettre l'objet recu dans la variable loan, initialisé précédamment.
        foreach ($arrayLoan as $loanPending) {
            $loan = $loanPending;
        }
        // Obtenir la date à l'instant et la mettre dans une variable.
        $dateTime = date_create("now");
        // Grâce à l'objet loan reçu, obtenir l'objet famille lié à ce prêt, et le mettre dans une variable.
        $family = $loan->getFamily();

        // Créer le formulaire symfony de la classe loan  dans la variable form. Permettrais à l'utilisateur de remplir uniquement 2 champs, le reste se fera automatiquement ou n'est pas nécéssaire.
        $form = $this->createFormBuilder($loan)
            ->add('completenessReturn', CheckboxType::class, ['label' => 'Le jeu est rendu complet?', 'required' => false])
            ->add('returnComment', TextareaType::class, ['label' => 'Commentaire (optionnel)', 'required' => false])
            ->getForm();
        // Envoyer la requête grâce à la méthod symfony, appliquée sur la variavble créee.
        $form->handleRequest($request);

        // Vérifier si le formulaire et soumis et conforme grace eux methodes symfony prévu à cette effet.
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer (avec ses nouvelles valeurs) les prêts avec findBy() avec l'idItem du jeu à retourner et la prop effectReturnDateTime à null (un seul résultat peux sortir), mettre sa dans une variable.
            $arrayLoan = $loanRepository->findBy(array('item' => $idItem, 'effectReturnDateTime' => null));
            // Boucler sur le tableau retourné , et mettre l'objet recu dans la variable loan, initialisé précédamment.
            foreach ($arrayLoan as $loanPending) {
                $loan = $loanPending;
            }

            // Appliquer à la variable loan une date de retour, grâce à la variable créee plus haut.
            $loan->setEffectReturnDateTime($dateTime);
            // Ajouter une possibilité de prêt supplémentaire à la famille, puisqu'un article est restitué.
            $family->setMaxLoanSimultaneous($family->getMaxLoanSimultaneous() + 1);
            // Rendre l'article disponible.
            $item->setAvailable(1);


            if ($loan->isCompletenessReturn() == 0) {


                $item->setCompleteness(0);
                $item->setAvailable(0);
                $family->setIncompleteReturnNb($family->getIncompleteReturnNb() + 1);
                $family->setIncompleteReturn(1);
                $family->setBlocked(1);
                $this->addFlash('warning', 'Retour effectué: incomplet');


            } else {


                $item->setCompleteness(1);
                $item->setAvailable(1);
                $family->setIncompleteReturnNb($family->getIncompleteReturnNb() + 1);


                $this->addFlash('success', 'Retour effectué: complet');
            }
            $loanRepository->add($loan, true);
            $itemRepository->add($item, true);
            $familyRepository->add($family, true);


            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('loan/show_return.html.twig', [
            'loan' => $loan,
            'form' => $form,
            'idItem' => $idItem,
            'item' => $item,

            'family' => $family,


        ]);
    }


    #[Route('/{id}/edit', name: 'app_loan_edit', methods: ['GET', 'POST'])]
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
