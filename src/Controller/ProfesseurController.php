<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Entity\ProfesseurSearch;
use App\Form\ProfesseurSearchType;
use App\Form\ProfesseurType;
use App\Repository\ProfesseurRepository;
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
    public function new(Request $request): Response
    {
        $professeur = new Professeur();

        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($professeur);
            $entityManager->flush();
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
        }

        return $this->redirectToRoute('professeur_index');
    }
}
