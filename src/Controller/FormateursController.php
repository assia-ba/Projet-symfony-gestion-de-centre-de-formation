<?php

namespace App\Controller;

use App\Entity\Formateurs;
use App\Form\FormateursType;
use App\Repository\FormateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/formateurs")
 */
class FormateursController extends AbstractController
{
    /**
     * @Route("/", name="formateurs_index", methods={"GET"})
     */
    public function index(FormateursRepository $formateursRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Formateurs::class)->findBy([],['id' => 'asc']);

        $formateurs = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            25 // Nombre de résultats par page
        );
        
        return $this->render('formateurs/index.html.twig', [
            'formateurs' => $formateurs,
        ]);
    }

    /**
     * @Route("/new", name="formateurs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $formateur = new Formateurs();
        $form = $this->createForm(FormateursType::class, $formateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formateur);
            $entityManager->flush();

            return $this->redirectToRoute('formateurs_index');
        }

        return $this->render('formateurs/new.html.twig', [
            'formateur' => $formateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formateurs_show", methods={"GET"})
     */
    public function show(Formateurs $formateur): Response
    {
        return $this->render('formateurs/show.html.twig', [
            'formateur' => $formateur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="formateurs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formateurs $formateur): Response
    {
        $form = $this->createForm(FormateursType::class, $formateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formateurs_index');
        }

        return $this->render('formateurs/edit.html.twig', [
            'formateur' => $formateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formateurs_delete", methods={"POST"})
     */
    public function delete(Request $request, Formateurs $formateur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formateur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('formateurs_index');
    }
}
