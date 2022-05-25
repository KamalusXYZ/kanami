<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemSearchType;
use App\Form\ItemType;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {



        return $this->render('main/home.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }





}
