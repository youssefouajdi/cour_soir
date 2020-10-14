<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Entity\ProfesseurSearch;
use App\Entity\Notification;
use App\Form\ProfesseurSearchType;
use App\Form\ProfesseurType;
use App\Repository\ProfesseurRepository;
use App\Repository\MatiereRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/professeur")
 */
class ProfesseurController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="professeur_index", methods={"GET"})
     * @param ProfesseurRepository $professeurRepository
     * @param Request $request
     * @return Response
     */
    public function index(ProfesseurRepository $professeurRepository,Request $request): Response
    {
        $module = $request->query->get('module', null);
        if ($request->isMethod('POST')) {
            $module = $request->request->get('module', null);
        }
        $search = new ProfesseurSearch();
        $form=$this->createForm(ProfesseurSearchType::class,$search, [
            'module' => $module
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search->setNomProf($form['id_professeur']->getData()->getNom());
            $search->setPrenomProf($form['id_professeur']->getData()->getPrenom());
        }
        return $this->render('professeur/index.html.twig', [
            'professeurs' => $professeurRepository->findAllProf($search),
            'form'=>$form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/new", name="professeur_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request,MatiereRepository $professeurRepository): Response
    {
        $idMatier = $request->query->get('id_matiere', null);
        if ($request->isMethod('POST')) {
            $idMatier = $request->request->get('id_matiere', null);
        }
        $professeur = new Professeur();
        $form = $this->createForm(ProfesseurType::class, $professeur, [
            'id_matiere' => $idMatier
        ]);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $tableauprofesseur=[];
            if($form['id_professeur']->getData()!=null){
                array_push($tableauprofesseur,$form['id_professeur']->getData()); 
            }
            if($form['id_professeur2']->getData()!=null){
                array_push($tableauprofesseur,$form['id_professeur2']->getData()) ;
            }
            if($form['id_professeur3']->getData()!=null){
                array_push($tableauprofesseur,$form['id_professeur3']->getData()) ;
            }
            $k=count($tableauprofesseur);
            for($i=0;$i<$k;$i++){
                $group = new Professeur();
                $group->setNom($form['nom']->getData());
                $group->setPrenom($form['prenom']->getData());
                $group->setTel($form['tel']->getData());
                $group->setIdUser($form['id_user']->getData());
                $group->setIdMatiere($tableauprofesseur[$i]);
                $entityManager->persist($group);
            }
            $entityManager->flush(); 
            $notification = new Notification();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("un professeur a ete ajoute");
            $notification->setType("new");
            $notification->setLu(FALSE);
            $entityManager1->persist($notification);
            $entityManager1->flush();
            return $this->redirectToRoute('professeur_index');
        }

        return $this->render('professeur/new.html.twig', [
            'professeur' => $professeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="professeur_show", methods={"GET"})
     * @param Professeur $professeur
     * @return Response
     */
    public function show(Professeur $professeur): Response
    {
        return $this->render('professeur/show.html.twig', [
            'professeur' => $professeur,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/edit", name="professeur_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Professeur $professeur
     * @return Response
     */
    public function edit(Request $request, Professeur $professeur): Response
    {
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification = new Notification();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("modificationd un professeur");
            $notification->setLu(FALSE);
            $notification->setType("edit");
            $entityManager1->persist($notification);
            $entityManager1->flush();
            return $this->redirectToRoute('professeur_index');
        }

        return $this->render('professeur/edit.html.twig', [
            'professeur' => $professeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="professeur_delete", methods={"DELETE"})
     * @param Request $request
     * @param Professeur $professeur
     * @return Response
     */
    public function delete(Request $request, Professeur $professeur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professeur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($professeur);
            $entityManager->flush();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification = new Notification();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("suppression d un professeur");
            $notification->setLu(FALSE);
            $notification->setType("delete");
            $entityManager1->persist($notification);
            $entityManager1->flush();
        }

        return $this->redirectToRoute('professeur_index');
    }
}
