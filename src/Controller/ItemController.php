<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Payment;
use App\Form\ItemType;
use App\Repository\FamilyRepository;
use App\Repository\ItemRepository;
use App\Repository\LoanRepository;
use App\Repository\MemberRepository;
use App\Repository\PaymentRepository;
use App\Repository\RelationshipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/item')]
class ItemController extends AbstractController
{
    #[Route('/', name: 'app_item_index', methods: ['GET'])]
    public function index(ItemRepository $itemRepository): Response
    {
        return $this->render('item/index.html.twig', [
            'items' => $itemRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ItemRepository $itemRepository): Response
    {
        $item = new Item();

        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);
        $dateTime = date_create("now");

        if ($form->isSubmitted() && $form->isValid()) {

            $item->setArchive(0);
            $item->setRegisterDateTime($dateTime);
            $itemRepository->add($item, true);

            return $this->redirectToRoute('app_category_dependance_new', ['idItem' => $item->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item/new.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_item_show', methods: ['GET'])]
    public function show(Item $item, LoanRepository $loanRepository, MemberRepository $memberRepository, RelationshipRepository $relationshipRepository, $id): Response
    {

        $loans = $loanRepository->findBy(
            array('item' => $id, 'effectReturnDateTime' => null)
        );

        $loan = '';
        foreach ($loans as $loan) {
            $loan = $loan;
        }


        return $this->render('item/show.html.twig', [
            'item' => $item,
            'loan' => $loan,



        ]);
    }

    #[Route('/resolving/item{idItem}/family{idFamily}', name: 'app_resolve_confirmation', methods: ['GET', 'POST'])]
    public function resolveConfirmation(Request $request, LoanRepository $loanRepository, ItemRepository $itemRepository, FamilyRepository $familyRepository, $idItem, $idFamily): Response
    {


        $loan = 0;
        $item = $itemRepository->find($idItem);
        $family = $familyRepository->find($idFamily);
        $loans = $loanRepository->findBy(array('item' => $idItem));
        foreach ($loans as $loan)
            $loan = $loan;

        $loanStayIncomplete = count($loanRepository->findBy(array('family' => $idFamily, 'completenessReturn' => 0)));
//        if($loanStayIncomplete == 1)


        $form = $this->createFormBuilder($loan)
            ->add('completenessReturn', CheckboxType::class, ['label' => 'Le jeu a été complété?', 'required' => true])
            ->add('returnComment', ChoiceType::class, [
                'choices' => [
                    'Pièce retrouvée' => 'Pièce retrouvée',
                    'Pièce rachetée' => 'Pièce rachetée',
                    'Autre ' => 'Pièce ni racheté ni retrouvée: autre',
                ]
            ])
            ->getForm();


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $item->setAvailable(1);
            $item->setCompleteness(1);
            $itemRepository->add($item, true);


            return $this->redirectToRoute('app_family_check', ['idFamily' => $idFamily], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item/resolve.html.twig', [
            'item' => $item,
            'form' => $form,
            'family' => $family
        ]);
    }

    #[Route('/pay-to-resolving/item{idItem}/family{idFamily}', name: 'app_pay_to_resolve_confirmation', methods: ['GET', 'POST'])]
    public function payToResolveConfirmation(Request $request, PaymentRepository $paymentRepository, LoanRepository $loanRepository, ItemRepository $itemRepository, FamilyRepository $familyRepository, $idItem, $idFamily): Response
    {
        $date = date_create("now");
        $payment = new Payment();
        $loan = 0;
        $item = $itemRepository->find($idItem);
        $family = $familyRepository->find($idFamily);
        $loans = $loanRepository->findBy(array('item' => $idItem));
        foreach ($loans as $loan)
            $loan = $loan;

        $loanStayIncomplete = count($loanRepository->findBy(array('family' => $idFamily, 'completenessReturn' => 0)));

        $form = $this->createFormBuilder($payment)
            ->add('paymentKind', ChoiceType::class, [
                'choices' => [
                    'Carte bancaire' => 'Carte bancaire',
                    'Espèce' => 'Espèce',
                    'Chèque' => 'Chèque',
                    'Autre ' => 'autre',
                ], 'label' => 'Moyen de paiement:'
            ])
            ->add('paymentAmount', MoneyType::class, ['label' => 'Somme à payer pour ce jeu:', 'required' => true])
            ->add('paymentComment', TextareaType::class, ['label' => 'Commentaire suite à la résolution du litige.'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $family->setBlocked(0);
            $family->setIncompleteReturn(0);
            $loan->setReturnComment('Jeu remboursé');
            $loan->setCompletenessReturn(1);
            $item->setAvailable(1);
            $item->setCompleteness(1);
            $payment->setPaymentDate($date);
            $itemRepository->add($item, true);
            $loanRepository->add($loan, true);
            $familyRepository->add($family, true);
            $paymentRepository->add($payment, true);

            return $this->redirectToRoute('app_family_check', ['idFamily' => $idFamily], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item/resolve.html.twig', [
            'item' => $item,
            'form' => $form,
            'family' => $family,

        ]);
    }

    #[Route('/free-resolving/item{idItem}/family{idFamily}', name: 'app_free_resolve_confirmation', methods: ['GET', 'POST'])]
    public function freeResolveConfirmation(Request $request, PaymentRepository $paymentRepository, LoanRepository $loanRepository, ItemRepository $itemRepository, FamilyRepository $familyRepository, $idItem, $idFamily): Response
    {
        $date = date_create("now");
        $payment = new Payment();
        $loan = 0;
        $item = $itemRepository->find($idItem);
        $family = $familyRepository->find($idFamily);
        $loans = $loanRepository->findBy(array('item' => $idItem));
        foreach ($loans as $loan)
            $loan = $loan;

        $loanStayIncomplete = count($loanRepository->findBy(array('family' => $idFamily, 'completenessReturn' => 0)));

        $form = $this->createFormBuilder($item)
            ->add('available', CheckboxType::class, ['label' => 'Le jeu est t il remis en circulation? Si vous ne cochez pas, le seul moyen de le remettre en circulation sera de recréer une nouvelle fiche.'])
            ->add('completeness', CheckboxType::class, ['label' => 'ATTENTION En cochant cette case le jeu si il est remis en circulation sera considéré comme complet dans cette état!  '])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payment->setPaymentKind("Pas de règlement: annulation de la dette.");
            $payment->setPaymentDate($date);
            $payment->setFamily($family);
            $payment->setPaymentAmount(0);
            $payment->setPaymentComment("Litige clos: dette non reglée.");
            $family->setBlocked(0);
            $family->setIncompleteReturn(0);
            $loan->setReturnComment('Jeu non restitué par la famille');
            $loan->setCompletenessReturn(1);
            $item->setAvailable(1);
            $item->setCompleteness(1);
            $payment->setPaymentDate($date);
            $itemRepository->add($item, true);
            $loanRepository->add($loan, true);
            $familyRepository->add($family, true);
            $paymentRepository->add($payment, true);

            return $this->redirectToRoute('app_family_check', ['idFamily' => $idFamily], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item/resolve.html.twig', [
            'item' => $item,
            'form' => $form,
            'family' => $family,

        ]);
    }


    #[Route('/check/family{idFamily}', name: 'app_family_check', methods: ['GET', 'POST'])]
    public function checkFamily(Request $request, FamilyRepository $familyRepository, LoanRepository $loanRepository, $idFamily): Response
    {

        $family = $familyRepository->find($idFamily);

        if (count($loanRepository->findBy(array('family' => $idFamily, 'completenessReturn' => 0))) == 0) {
            $family->setBlocked(0);
            $family->setIncompleteReturn(0);

            $familyRepository->add($family, true);


            return $this->redirectToRoute('app_family_show', ['idFamily' => $idFamily], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('family/show.html.twig', [
            'idFamily' => $idFamily,
            'family' => $family,


        ]);
    }

    #[Route('/{id}/edit', name: 'app_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FamilyRepository $familyRepository, Item $item, ItemRepository $itemRepository, LoanRepository $loanRepository, $id): Response
    {
        // recherche d'un pret qui a été restitué incomplet.[arrive sous forme de tableau]
        $loan = '';
        $loans = $loanRepository->findBy(['item' => $id, 'completenessReturn' => 0]);
        //boucle sur le tableau qui ne doit contenir qu'un resultat
        foreach ($loans as $loan) {
            $loan = $loan;


        }


        $form = $this->createFormBuilder($item)
            ->add('name', TextType::class, ["label" => "Nom: "])
            ->add('ref', TextType::class, ["label" => "Référence interne à la ludothèque: ", 'required' => false])
            ->add('lang', ChoiceType::class, [
                'choices' => [
                    'Français' => 'Français',
                    'Anglais' => 'Anglais',
                    'Allemand' => 'Allemand',
                    'Espagnol' => 'Espagnol',
                    'Italien' => 'Italien',
                    'Autre' => 'Autre',

                ],
                'preferred_choices' => ['Français'],
            ])
            ->add('publisherGameDuration', ChoiceType::class, [
                'choices' => [

                    'Moins de 15m' => "Moins de 15m",
                    'moins de 30m' => "moins de 30m",
                    'de 30m à 1h' => "de 30m à 1h",
                    'de 1h à 2h' => "de 1h à 2h",
                    'de 2h à 3h' => "de 2h à 3h",
                    'de 3h à 4h' => "de 3h à 4h",
                    'plus de 4h' => "plus de 4h",


                ], "label" => "Durée d'une partie selon l'éditeur: ", 'required' => false
            ])
            ->add('ourGameDuration', ChoiceType::class, [
                'choices' => [

                    'Moins de 15m' => "Moins de 15m",
                    'moins de 30m' => "moins de 30m",
                    'de 30m à 1h' => "de 30m à 1h",
                    'de 1h à 2h' => "de 1h à 2h",
                    'de 2h à 3h' => "de 2h à 3h",
                    'de 3h à 4h' => "de 3h à 4h",
                    'plus de 4h' => "plus de 4h",


                ], "label" => "Durée d'une partie selon l'estimation de la ludo: ", 'required' => false
            ])
            ->add('playerNbMin', IntegerType::class, ["label" => "Nombre de joueur minimum: ", 'required' => false,])
            ->add('playerNbMax', IntegerType::class, ["label" => "Nombre de joueur maximum: ", 'required' => false])
            ->add('ageMin', IntegerType::class, ["label" => "Age minimum conseillé par l'éditeur: ", 'required' => false])
            ->add('author', TextType::class, ["label" => "Auteur: ", 'required' => false])
            ->add('illustrator', TextType::class, ["label" => "Illustrateur: ", 'required' => false])
            ->add('publisher', TextType::class, ["label" => "Editeur: ", 'required' => false])
            ->add('itemCondition', ChoiceType::class, [
                'choices' => [

                    'Neuf' => "Neuf",
                    'Moyen' => "Moyen",
                    'Usé' => "Usé",
                    'Très usé' => "Très usé",
                    'à définir' => "à définir",


                ], "label" => "Etat d'usure du jeu: ", 'required' => false
            ])
            ->add('gamePrice', MoneyType::class, ["label" => "Valeur du jeu: ", 'required' => false,
                'empty_data' => 0])
            ->add('gameOrigin', TextType::class, ["label" => "Provenance: ", 'required' => false])
            ->add('copyNumber', IntegerType::class, ["label" => "Remplir uniquement si le jeu est possédé en plusieurs exemplaire, indiquez le numéro de l'exemplaire: ", 'required' => false])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemRepository->add($item, true);

            return $this->redirectToRoute('app_item_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item/edit.html.twig', [
            'item' => $item,
            'form' => $form,
            'loan' => $loan
        ]);
    }


    #[Route('/{id}', name: 'app_item_delete', methods: ['POST'])]
    public function delete(Request $request, Item $item, ItemRepository $itemRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $item->getId(), $request->request->get('_token'))) {
            $item->setArchive(1);
            $itemRepository->add($item, true);
        }


        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/replace/{id}', name: 'app_item_replace', methods: ['POST'])]
    public function replace(Request $request, Item $item, ItemRepository $itemRepository): Response
    {

        if ($this->isCsrfTokenValid('replace' . $item->getId(), $request->request->get('_token'))) {


            $item->setArchive(0);
            $itemRepository->add($item, true);
        }

        return $this->redirectToRoute('app_item_list_deleted', [], Response::HTTP_SEE_OTHER);
    }


}
