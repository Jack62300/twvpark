<?php

namespace App\Controller;

use DateTime;
use App\Form\GasType;
use App\Entity\Consigne;
use App\Entity\PretClef;
use App\Form\PretClefType;
use App\Repository\GasRepository;
use App\Repository\ConsigneRepository;
use App\Repository\PretClefRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
     * @Security("is_granted('ROLE_USER') and is_granted('ROLE_EDITOR') and is_granted('ROLE_ADMIN') and is_granted('ROLE_DEV')")
     */
class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ConsigneRepository $consigne, PretClefRepository $clef, Request $request, EntityManagerInterface $em, GasRepository $gasrepo): Response
    {
       
        $cons = $consigne->findBy([],['id' => 'DESC'],3);
        $key = $clef->findBy(['status' => '1'],['createdAt' => 'DESC']);
        $gas = $gasrepo->findBy([],['createdAt' => 'DESC']);
       
        foreach ($gas as $gasE) {
        if ($gasE->getNiveau() <= 30){
            $this->addFlash(
                'warning',
                'Gas en Logistique - Niveau trop bas, merci de suivre les instruction relatif dans les consignes'
            );
            break; 
        }
        }

        $form = $this->createForm(PretClefType::class);
        $form2 = $this->createForm(GasType::class);

        // Gère la soumission du formulaire si le formulaire a été soumis
        $form->handleRequest($request);
        $form2->handleRequest($request);
        
        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $donnees = $form->getData();           
            $em->persist($donnees);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }

        if ($form2->isSubmitted() && $form2->isValid()) {
            $donnees = $form2->getData();           
            $em->persist($donnees);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }





        return $this->render('home/index.html.twig', [
            'consignes' => $cons,
            'keys' => $key,
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'gass' => $gas,
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
