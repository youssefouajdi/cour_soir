<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Entity\Notification;
use App\Repository\PersonneRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/personne")
 */
class PersonneController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="personne_index", methods={"GET"})
     */
    public function index(PersonneRepository $personneRepository): Response
    {
        return $this->render('personne/index.html.twig', [
            'personnes' => $personneRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/new", name="personne_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personne);
            $entityManager->flush();
            $notification = new Notification();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("du personnel a ete ajoute ");
            $notification->setLu(FALSE);
            $notification->setType("new");
            $entityManager1->persist($notification);
            $entityManager1->flush();
            return $this->redirectToRoute('personne_index');
        }

        return $this->render('personne/new.html.twig', [
            'personne' => $personne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="personne_show", methods={"GET"})
     */
    public function show(Personne $personne): Response
    {
        return $this->render('personne/show.html.twig', [
            'personne' => $personne,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/edit", name="personne_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Personne $personne): Response
    {
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("modification info. direction");
            $notification->setLu(FALSE);
            $notification->setType("edit");
            $entityManager1->persist($notification);
            $entityManager1->flush();
            return $this->redirectToRoute('personne_index');
        }

        return $this->render('personne/edit.html.twig', [
            'personne' => $personne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="personne_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Personne $personne): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personne->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($personne);
            $entityManager->flush();
            $entityManager1 = $this->getDoctrine()->getManager();
            $notification->setDate(new \DateTime('now'));
            $notification->setSujet("suppression du personnel");
            $notification->setLu(FALSE);
            $notification->setType("delete");
            $entityManager1->persist($notification);
            $entityManager1->flush();
        }

        return $this->redirectToRoute('personne_index');
    }
}
