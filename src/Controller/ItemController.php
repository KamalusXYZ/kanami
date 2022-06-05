<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use App\Repository\FamilyRepository;
use App\Repository\ItemRepository;
use App\Repository\LoanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
    public function show(Item $item): Response
    {
        return $this->render('item/show.html.twig', [
            'item' => $item,
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
            'family' => $family

        ]);
    }

    #[Route('/{id}/edit', name: 'app_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Item $item, ItemRepository $itemRepository): Response
    {
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemRepository->add($item, true);

            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item/edit.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_item_delete', methods: ['POST'])]
    public function delete(Request $request, Item $item, ItemRepository $itemRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $item->getId(), $request->request->get('_token'))) {
            $itemRepository->remove($item, true);
        }

        return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
