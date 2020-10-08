<?php

namespace App\Controller;

use App\Entity\Affectation;
use App\Entity\Notification;
use App\Entity\Eleve;
use App\Form\AffectationType;
use App\Repository\AffectationRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/affectation")
 */
class AffectationController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="affectation_index", methods={"GET"})
     * @param AffectationRepository $affectationRepository
     * @return Response
     */
    public function index(AffectationRepository $affectationRepository): Response
    {

        return $this->render('affectation/index.html.twig', [
            'affectations' => $affectationRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/new/{ideleve}", name="affectation_new", methods={"GET","POST"})
     * @param Eleve $ideleve
     * @param Request $request
     * @return Response
     */
    public function new(Eleve $ideleve,Request $request): Response
    {
        $idMatier = $request->query->get('id_matiere', null);
        if ($request->isMethod('POST')) {
            $idMatier = $request->request->get('id_matiere', null);
        }
        $idMatier2 = $request->query->get('id_matiere2', null);
        if ($request->isMethod('POST')) {
            $idMatier2 = $request->request->get('id_matiere2', null);
        }
        $idMatier3 = $request->query->get('id_matiere3', null);
        if ($request->isMethod('POST')) {
            $idMatier3 = $request->request->get('id_matiere3', null);
        }
        $affectation = new Affectation();
        $affectation->setIdEleve($ideleve);
        $affectation->setJour(new DateTime());
        
        $form = $this->createForm(AffectationType::class, $affectation, [
            'id_matiere' => $idMatier,
            'id_matiere2' => $idMatier2,
            'id_matiere3'=>$idMatier3
        ]);
            
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $tableaumatiere=[];
            if($form['id_matiere']->getData()!=null){
                array_push($tableaumatiere,$form['id_matiere']->getData()); 
            }
            if($form['id_matiere2']->getData()!=null){
                array_push($tableaumatiere,$form['id_matiere2']->getData()) ;
            }
            if($form['id_matiere3']->getData()!=null){
                array_push($tableaumatiere,$form['id_matiere3']->getData()) ;
            }
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
            $k=count($tableaumatiere);
            for($i=0;$i<$k;$i++){
                $group = new Affectation();
                $group->setJour($form['jour']->getData());
               // $group->setIdProfesseur($tableauprofesseur[$i]);
                $group->setIdMatiere($tableaumatiere[$i]);
                $group->setPaye($form['paye']->getData());
                $group->setIdEleve($ideleve);
                $group->setReste($form['reste']->getData());
                $entityManager->persist($group);
            }
            $entityManager->flush();
            $notification = new Notification();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("un eleve a ete affecte a une matiere");
            $notification->setLu(FALSE);
            $notification->setType("new");
            $entityManager1->persist($notification);
            $entityManager1->flush();
            return $this->redirectToRoute('affectation_index');
        }

        return $this->render('affectation/new.html.twig', [
            'affectation' => $affectation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="affectation_show", methods={"GET"})
     * @param Affectation $affectation
     * @return Response
     */
    public function show(Affectation $affectation): Response
    {
        return $this->render('affectation/show.html.twig', [
            'affectation' => $affectation,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/edit", name="affectation_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Affectation $affectation
     * @return Response
     */
    public function edit(Request $request, Affectation $affectation): Response
    {
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("modification sur l affectation d un eleve");
            $notification->setLu(FALSE);
            $notification->setType("edit");
            $entityManager1->persist($notification);
            $entityManager1->flush();
            return $this->redirectToRoute('affectation_index');
        }

        return $this->render('affectation/edit.html.twig', [
            'affectation' => $affectation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="affectation_delete", methods={"DELETE"})
     * @param Request $request
     * @param Affectation $affectation
     * @return Response
     */
    public function delete(Request $request, Affectation $affectation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$affectation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($affectation);
            $entityManager->flush();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("suppression d une affectation ");
            $notification->setLu(FALSE);
            $notification->setType("delete");
            $entityManager1->persist($notification);
            $entityManager1->flush();
        }

        return $this->redirectToRoute('affectation_index');
    }
}
