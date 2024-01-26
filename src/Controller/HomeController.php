<?php

namespace App\Controller;

use App\Entity\Consigne;
use App\Repository\ConsigneRepository;
use App\Repository\PretClefRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    // #[Security("is_granted('ROLE_ADMIN') and is_granted('ROLE_USER')")]
    public function index(ConsigneRepository $consigne, PretClefRepository $clef): Response
    {
       
        $cons = $consigne->findBy([],['id' => 'DESC'],3);
        $key = $clef->findBy(['status' => '1'],['createdAt' => 'ASC'], 5);

        return $this->render('home/index.html.twig', [
            'consignes' => $cons,
            'keys' => $key
        ]);
    }
    #[Route('/calendar', name: 'app_calendar')]
    // #[Security("is_granted('ROLE_ADMIN') and is_granted('ROLE_USER')")]
    public function calendar(): Response
    {
       
       

        return $this->render('home/calendar.html.twig', [
        ]);
    }
}