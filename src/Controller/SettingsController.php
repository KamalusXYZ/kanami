<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends AbstractController
{
    #[Route('/settings', name: 'app_settings')]
    public function index(): Response
    {

        return $this->render('main/settings.html.twig', [
            'controller_name' => 'SettingsController',
        ]);
    }

    #[Route('/settings-family', name: 'app_settings_family')]
    public function indexFamily(): Response
    {

        return $this->render('main/settingsfamily.html.twig', [
            'controller_name' => 'SettingsController',
        ]);
    }

    #[Route('/settings-item', name: 'app_settings_item')]
    public function indexItem(): Response
    {

        return $this->render('main/settingsitem.html.twig', [
            'controller_name' => 'SettingsController',
        ]);

    }

    #[Route('/settings-member', name: 'app_settings_member')]
    public function indexMember(): Response
    {

        return $this->render('main/settingsmember.html.twig', [
            'controller_name' => 'SettingsController',
        ]);
    }

    #[Route('/list/deleted', name: 'app_item_list_deleted')]
    public function listDeletedItem(EntityManagerInterface $em): Response
    {
        $qb = $em->createQueryBuilder()
            ->select('i')
            ->from('App:Item', 'i')
            ->where('i.archive = 0')
            ->orderBy('i.name', 'ASC');


        $query = $qb->getQuery();
        $resultsItem = $query->execute();


        return $this->render('main/list-item-deleted.html.twig', [
            'controller_name' => 'SettingsController',
            'resultsItem' => $resultsItem,
        ]);
    }


}
