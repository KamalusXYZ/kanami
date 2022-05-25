<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/search')]
class SearchController extends AbstractController
{
    #[Route('/item/', name: 'app_search_item', methods: ['POST'])]
    public function itemSearch(Request $request): Response
    {
        dd($request->get("word"));
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }
}
