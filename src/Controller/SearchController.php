<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/search')]
class SearchController extends AbstractController
{
    #[Route('/item/', name: 'app_search_item', methods: ['POST'])]
    public function itemSearch(Request $request, EntityManagerInterface $em): Response
    {
        $resultsFamily = '';
        $searchWord = $request->get("word");

        $qb = $em->createQueryBuilder()
            ->select('i')
            ->from('App:Item','i')
            ->where('i.name LIKE :key')
            ->setParameter('key', '%'.$searchWord.'%');

        $query = $qb->getQuery();

        $resultsItem = $query->execute();


        return $this->render('main/home.html.twig', [
            'controller_name' => 'SearchController',
            'searchWord' => $searchWord,
            'resultsItem'=> $resultsItem,
            'resultsFamily'=> $resultsFamily
        ]);
    }

    #[Route('/family/', name: 'app_search_family', methods: ['POST'])]
    public function familySearch(Request $request, EntityManagerInterface $em): Response
    {
        $resultsItem = '';
        $searchWord = $request->get("word");

        $qb = $em->createQueryBuilder()
            ->select('m')
            ->from('App:Member','m')
//            ->innerJoin()
//                ->innerJoin()
            ->where('m.lastName LIKE :key')
            ->setParameter('key', '%'.$searchWord.'%');

        $query = $qb->getQuery();

        $resultsFamily = $query->execute();



        return $this->render('main/home.html.twig', [
            'controller_name' => 'SearchController',
            'searchWord' => $searchWord,
            'resultsFamily'=> $resultsFamily,
            'resultsItem'=> $resultsItem,
        ]);
    }
}
