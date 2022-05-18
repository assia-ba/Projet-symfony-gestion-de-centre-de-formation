<?php

namespace App\Controller;
use App\Entity\Inscription;
use App\Entity\Commentaires;
use App\Entity\Formations;
use App\Form\FormationsType;
use App\Form\InscriptionType;
use App\Form\CommentairesType;
use App\Repository\FormationsRepository;
use App\Repository\InscriptionRepository;
use App\Repository\CommentairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/formations")
 */
class FormationsController extends AbstractController
{
    /**
     * @Route("/calendar", name="formations_calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('formations/calendar.html.twig');
    }


    /**
     * @Route("/admin", name="formations_index1", methods={"GET"})
     */
    public function index1(FormationsRepository $formationsRepository ,Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Formations::class)->findBy([],['id' => 'asc']);

        $formations = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            25 // Nombre de résultats par page
        );
        return $this->render('formations/index1.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/calendrier", name="formations_Calendrier", methods={"GET"})
     */
    public function indexcalendar(FormationsRepository $formationsRepository ,Request $request): Response
    {
        $events = $formationsRepository->findAll();

        $frmt = [];
        foreach($events as $event){
            $frmt[] = [
                'id' => $event->getId(),
                'dateDebut' => $event->getDateDebut()->format('Y-m-d'),
                'dateFin' => $event->getDateFin()->format('Y-m-d'),
                'theme' => $event->getTheme(),
                'nom' => $event->getNom(),
                'description' => $event->getDescription(),
                'prix' => $event->getPrix(),
            ];
        }
        $data = json_encode($frmt);
        return $this->render('formations/calendrier.html.twig', compact('data'));
    }

     /**
     * @Route("/etudiant", name="formations_index2", methods={"GET"})
     */
    public function index2(FormationsRepository $formationsRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Formations::class)->findBy([],['id' => 'asc']);

        $formations = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            25 // Nombre de résultats par page
        );
        return $this->render('formations/index2.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/admin/new", name="formations_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $formation = new Formations();
        $form = $this->createForm(FormationsType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('formations_index1');
        }

        return $this->render('formations/new.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/etudiant", name="formations_show", methods={"GET","POST"})
     */
    public function show(Request $request, Formations $formation): Response
    {
        $commentaire = new Commentaires();
        $commentaireForm= $this->createForm(CommentairesType::class, $commentaire);
        $commentaireForm->handleRequest($request);

      

        if($commentaireForm->isSubmitted() && $commentaireForm->isValid()){
            $commentaire->setFormation($formation);   
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('formations_index2');
         }

        return $this->render('formations/show.html.twig',[
            'formation' => $formation,
            'commentaireForm' => $commentaireForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit/admin", name="formations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formations $formation): Response
    {
        $form = $this->createForm(FormationsType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formations_index1');
        }

        return $this->render('formations/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/admin", name="formations_delete", methods={"POST"})
     */
    public function delete(Request $request, Formations $formation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('formations_index1');
    }

    /**
     * @Route("/{id}/inscription/etudiant", name="inscription_form", methods={"GET","POST"})
     */
    public function inscription(Request $request, Formations $formation): Response
    {
        $inscription = new Inscription();
        $inscriptionForm= $this->createForm(InscriptionType::class, $inscription);
        $inscriptionForm->handleRequest($request);

      

        if($inscriptionForm->isSubmitted() && $inscriptionForm->isValid()){
            $inscription->setIdFormation($formation);   
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($inscription);
            $em->flush();

            return $this->redirectToRoute('formations_index2');
         }

        return $this->render('inscription/new.html.twig',[
            'formation' => $formation,
            'inscriptionForm' => $inscriptionForm->createView(),
        ]);
    }




}
