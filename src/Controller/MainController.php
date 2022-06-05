<?php

namespace App\Controller;

use App\Repository\LoanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class MainController extends AbstractController
{


    public function __construct(Environment $maDate)
    {
        $this->maDate = $maDate;

    }

    #[Route('/', name: 'app_main')]
    public function index(LoanRepository $loanRepository): Response
    {
        $searchWord = '';
        $resultsItem = '';
        $resultsFamily = '';




        return $this->render('main/home.html.twig', [
            'controller_name' => 'MainController',
            'searchWord'=>$searchWord,
            'resultsItem'=>$resultsItem,
            'resultsFamily'=>$resultsFamily,

        ]);
    }





}
