<?php

namespace App\Controller;
use App\Entity\Formations;
use App\Form\FormationsType;
use App\Form\RechercheType;
use App\Repository\FormationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;



class RechercheController extends AbstractController
{
    /**
    * @Route("/formations/recherche", name="recherche_form" , methods={"GET","POST"})
    */
    public function searchFormation(Request $request): Response
    {
        $formation=[];
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        if($form->handleRequest($request)->isSubmitted() && $form->isValid()){
            $criteria = $form->getData();
            dd($criteria);
            $forationn= $FormationsRepository->searchFormation($criteria);
        }
        return $this->render('formations/recherche/Recherche_form.html.twig',[
            'form_search '=> $form->createView(),
            'formation' => $formation,
        ]);
    }

}