<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Entity\Notification;
use App\Repository\EleveRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/eleve")
 */
class EleveController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="eleve_index", methods={"GET"})
     */
    public function index(EleveRepository $eleveRepository): Response
    {
        return $this->render('eleve/index.html.twig', [
            'eleves' => $eleveRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/new", name="eleve_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
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
        $eleve = new Eleve();
        $eleve->setDtInscription(new \DateTime('now'));
        $form = $this->createForm(EleveType::class, $eleve, [
            'id_matiere' => $idMatier,
            'id_matiere2' => $idMatier2,
            'id_matiere3'=>$idMatier3
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            if($form->getData()->getNiveau()=== '1 AC' ||
            $form->getData()->getNiveau()=== '2 AC' ||
            $form->getData()->getNiveau()=== '3 AC' ||
            $form->getData()->getNiveau()=== '1 BAC S' ||
            $form->getData()->getNiveau()=== '1 BAC SM' ||
            $form->getData()->getNiveau()=== '2 BAC PC' ||
            $form->getData()->getNiveau()=== '2 BAC SVT' ||
            $form->getData()->getNiveau()=== '2 BAC SM' ){
                $eleve->setType("eleve");
            }else{
                $eleve->setType("etudiant");
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eleve);
            $entityManager->flush();
            $notification = new Notification();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("un nouveau eleve a ete ajouter");
            $notification->setLu(FALSE);
            $notification->setType("new");
            $entityManager1->persist($notification);
            $entityManager1->flush();
            return $this->redirectToRoute('eleve_index');
        }

        return $this->render('eleve/new.html.twig', [
            'eleve' => $eleve,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{idEleve}", name="eleve_show", methods={"GET"})
     */
    public function show(Eleve $eleve): Response
    {
        return $this->render('eleve/show.html.twig', [
            'eleve' => $eleve,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{idEleve}/edit", name="eleve_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Eleve $eleve): Response
    {
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("modification sur les informations d un eleve");
            $notification->setLu(FALSE);
            $notification->setType("edit");
            $entityManager1->persist($notification);
            $entityManager1->flush();
            return $this->redirectToRoute('eleve_index');
        }

        return $this->render('eleve/edit.html.twig', [
            'eleve' => $eleve,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{idEleve}", name="eleve_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Eleve $eleve): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eleve->getIdEleve(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eleve);
            $entityManager->flush();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("suppression d un eleve");
            $notification->setLu(FALSE);
            $notification->setType("delete");
            $entityManager1->persist($notification);
            $entityManager1->flush();
        }

        return $this->redirectToRoute('eleve_index');
    }
}
