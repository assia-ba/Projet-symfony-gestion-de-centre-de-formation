<?php

namespace App\Controller;

use App\Entity\Suggestions;
use App\Form\SuggestionsType;
use App\Repository\SuggestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/suggestions")
 */
class SuggestionsController extends AbstractController
{
    /**
     * @Route("/", name="suggestions_index", methods={"GET"})
     */
    public function index(SuggestionsRepository $suggestionsRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Suggestions::class)->findBy([],['id' => 'asc']);

        $suggestions = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            25 // Nombre de résultats par page
        );
       
        return $this->render('suggestions/index.html.twig', [
            'suggestions' => $suggestions,
        ]);
    }

    /**
     * @Route("/new", name="suggestions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $suggestion = new Suggestions();
        $form = $this->createForm(SuggestionsType::class, $suggestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($suggestion);
            $entityManager->flush();

            return ($this->redirectToRoute('etudiant'));
        }

        return $this->render('suggestions/new.html.twig', [
            'suggestion' => $suggestion,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/new2", name="suggestions_new2", methods={"GET","POST"})
     */
    public function new2(Request $request): Response
    {
        $suggestion = new Suggestions();
        $form = $this->createForm(SuggestionsType::class, $suggestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($suggestion);
            $entityManager->flush();

            return ($this->redirectToRoute('blog'));
        }

        return $this->render('suggestions/new2.html.twig', [
            'suggestion' => $suggestion,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="suggestions_show", methods={"GET"})
     */
    public function show(Suggestions $suggestion): Response
    {
        return $this->render('suggestions/show.html.twig', [
            'suggestion' => $suggestion,
        ]);
    }


    /**
     * @Route("/{id}", name="suggestions_delete", methods={"POST"})
     */
    public function delete(Request $request, Suggestions $suggestion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$suggestion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($suggestion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('suggestions_index');
    }
}
