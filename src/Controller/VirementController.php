<?php

namespace App\Controller;

use App\Entity\Virement;
use App\Form\VirementType;
use App\Entity\Notification;
use App\Repository\VirementRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/virement")
 */
class VirementController extends AbstractController
{
    /**
     *
     * @Route("/", name="virement_index", methods={"GET"})
     */
    public function index(VirementRepository $virementRepository): Response
    {
        return $this->render('virement/index.html.twig', [
            'virements' => $virementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="virement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $virement = new Virement();
        $form = $this->createForm(VirementType::class, $virement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($virement);
            $entityManager->flush();
            $notification = new Notification();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("un virement a ete effectue");
            $notification->setLu(FALSE);
            $entityManager1->persist($notification);
            $notification->setType("new");
            $entityManager1->flush();
            return $this->redirectToRoute('virement_index');
        }

        return $this->render('virement/new.html.twig', [
            'virement' => $virement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idVirement}", name="virement_show", methods={"GET"})
     */
    public function show(Virement $virement): Response
    {
        return $this->render('virement/show.html.twig', [
            'virement' => $virement,
        ]);
    }

    /**
     * @Route("/{idVirement}/edit", name="virement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Virement $virement): Response
    {
        $form = $this->createForm(VirementType::class, $virement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("modification d un virement");
            $notification->setLu(FALSE);
            $notification->setType("edit");
            $entityManager1->persist($notification);
            $entityManager1->flush();
            return $this->redirectToRoute('virement_index');
        }

        return $this->render('virement/edit.html.twig', [
            'virement' => $virement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idVirement}", name="virement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Virement $virement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$virement->getIdVirement(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($virement);
            $entityManager->flush();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("suppression d un virement");
            $notification->setLu(FALSE);
            $notification->setType("delete");
            $entityManager1->persist($notification);
            $entityManager1->flush();
        }

        return $this->redirectToRoute('virement_index');
    }
}
