<?php

namespace App\Controller;

use App\Repository\ConsigneRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConsigneController extends AbstractController
{
    #[Route('/consigne', name: 'app_consigne')]
    public function index(ConsigneRepository $consigne): Response
    {
        $cons = $consigne->findBy( [], ['id' => 'DESC']);
        return $this->render('consigne/index.html.twig', [
            'consignes' => $cons,
        ]);
    }
}
