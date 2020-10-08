<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\PaiementMatiere;
use App\Entity\Notification;
use App\Form\PaiementType;
use App\Repository\PaiementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paiement")
 */
class PaiementController extends AbstractController
{
    /**
     * @Route("/", name="paiement_index", methods={"GET"})
     */
    public function index(PaiementRepository $paiementRepository): Response
    {
        return $this->render('paiement/index.html.twig', [
            'paiements' => $paiementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="paiement_new", methods={"GET","POST"})
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
        $paiement = new Paiement();
        $paiement->setDtPaiement(new \DateTime('now'));
        $form = $this->createForm(PaiementType::class, $paiement ,[
            'id_matiere' => $idMatier,
            'id_matiere2' => $idMatier2,
            'id_matiere3'=>$idMatier3
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $a=[];
            if($idMatier!=null){
                array_push($a,$idMatier);
            }
            if($idMatier2!=null){
                array_push($a,$idMatier2);
            }
            if($idMatier3!=null){
                array_push($a,$idMatier3);
            }
            $k=count($a);
            $entityManager = $this->getDoctrine()->getManager();
                $group = new Paiement();
                $group->setDtPaiement($form['dtPaiement']->getData());
                $group->setMode($form['mode']->getData());
                $group->setIdEleve($form['idEleve']->getData());
                $group->setMontantTotal($form['montantTotal']->getData());
                $group->setMotantRest($form['motantRest']->getData());
                $entityManager->persist($group);
            $entityManager->flush();
            $notification = new Notification();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("un paiement a ete effectue");
            $notification->setLu(FALSE);
            $notification->setType("new");
            $entityManager1->persist($notification);
            $entityManager1->flush();
            return $this->redirectToRoute('paiement_index');
        }

        return $this->render('paiement/new.html.twig', [
            'paiement' => $paiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPaiement}", name="paiement_show", methods={"GET"})
     */
    public function show(Paiement $paiement): Response
    {
        return $this->render('paiement/show.html.twig', [
            'paiement' => $paiement,
        ]);
    }

    /**
     * @Route("/{idPaiement}/edit", name="paiement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Paiement $paiement): Response
    {
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("modificationd un paiement");
            $notification->setLu(FALSE);
            $notification->setType("edit");
            $entityManager1->persist($notification);
            $entityManager1->flush();
            return $this->redirectToRoute('paiement_index');
        }

        return $this->render('paiement/edit.html.twig', [
            'paiement' => $paiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPaiement}", name="paiement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Paiement $paiement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paiement->getIdPaiement(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paiement);
            $entityManager->flush();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("suppression d un paiement");
            $notification->setLu(FALSE);
            $notification->setType("delete");
            $entityManager1->persist($notification);
            $entityManager1->flush();
        }

        return $this->redirectToRoute('paiement_index');
    }
}
