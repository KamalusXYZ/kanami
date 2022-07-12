<?php

namespace App\Controller;

use App\Entity\Relationship;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/search')]
class SearchController extends AbstractController
{
    #[Route('/item/', name: 'app_search_item', methods: ['POST'])]
    public function itemSearch(Request $request, EntityManagerInterface $em): Response
    {

        $resultsFamily = '';
        $resultsItem = '';

        $searchWord = $request->get("word");

        $qb = $em->createQueryBuilder()
            ->select('i')
            ->from('App:Item', 'i')
            ->where('i.name LIKE :key')
            ->andWhere('i.archive != 1')
            ->setParameter('key', '%' . $searchWord . '%');

        $query = $qb->getQuery();

        if ($searchWord != '')
            $resultsItem = $query->execute();


        return $this->render('main/home.html.twig', [
            'controller_name' => 'SearchController',
            'searchWord' => $searchWord,
            'resultsItem' => $resultsItem,
            'resultsFamily' => $resultsFamily
        ]);
    }

    #[Route('/family/', name: 'app_search_family', methods: ['POST'])]
    public function familySearch(Request $request, EntityManagerInterface $em): Response
    {
        $resultsItem = '';
        $resultsFamily = '';
        $searchWord = $request->get("word");

// requete faite avec un innejoin en dql pour vérifier que le resultat de la recherche correspond  un titulaire càd que son id match avec celui de la table relationship, et que la propriété isowner soit sur '1'
        $qb = $em->createQueryBuilder()
            ->select('m')
            ->from('App:Member', 'm')
            ->where('m.lastName LIKE :key')
            ->innerJoin(Relationship::class, 'r', 'WITH', 'r.member = m.id and r.isOwner = 1')
            ->setParameter('key', '%' . $searchWord . '%');


        $query = $qb->getQuery();

        if ($searchWord != '')
            $resultsFamily = $query->execute();


        return $this->render('main/home.html.twig', [
            'controller_name' => 'SearchController',
            'searchWord' => $searchWord,
            'resultsFamily' => $resultsFamily,
            'resultsItem' => $resultsItem,

        ]);
    }
}
