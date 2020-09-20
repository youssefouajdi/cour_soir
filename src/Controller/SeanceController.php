<?php

namespace App\Controller;
use App\Entity\Seance;
use App\Form\SeanceType;
use App\Repository\SeanceRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/seance")
 */
class SeanceController extends AbstractController
{
    /**
     * @Route("/", name="seance_index", methods={"GET"})
     * @param SeanceRepository $seanceRepository
     * @return Response
     */
    public function index(SeanceRepository $seanceRepository): Response
    {
        return $this->render('seance/index.html.twig', [
            'seances' => $seanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/calendar", name="seance_calendar", methods={"GET"})
     * @param SeanceRepository $seance
     * @return Response
     */
    public function calendar(SeanceRepository $seance): Response
    {
        $events=$seance->findAll();
        $rdvs=[];
        foreach ($events as $event){
            $rdvs[]=[
                'id'=>$event->getIdSeance(),
                'title'=>$event->getSalle().' '.$event->getIdMatiere().' '.$event->getIdProfesseur(),
                'start'=>$event->getJour()->format('Y-m-d').' '.$event->getHDebut()->format('H:i:s'),
                'end'=>$event->getJour()->format('Y-m-d').' '.$event->getHFin()->format('H:i:s'),
                'description'=>$event->getEffectuer(),
            ];
        }
        $data=json_encode($rdvs);
        return $this->render('seance/calendar.html.twig',compact('data'));
    }

    /**
     * @Route("/new", name="seance_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $seance = new Seance();
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $jourdelasemaine=$form['jourdelasemaine']->getData();
            $dtdebut=$form['dtdebut']->getData();
            $dtfin=$form['dtfin']->getData();
            $dtdebut=strtotime($dtdebut->format("Y-m-d"));
            $dtfin=$dtfin->getTimestamp();
            $j=count($jourdelasemaine);
            $a=[];
            while($dtdebut<$dtfin){
                for($i=0;$i<$j;$i++){
                    if($jourdelasemaine[$i] == date('l',$dtdebut)){
                        array_push($a,date('Y-m-d',$dtdebut) );
                    }
                }
                $dtdebut=strtotime("+1 day",$dtdebut);
            }
            $k=count($a);
            $entityManager = $this->getDoctrine()->getManager();
            for($i=0;$i<$k;$i++){

                $group = new Seance();
                $group->setJour(DateTime::createFromFormat('Y-m-d', $a[$i]));
                $group->setIdProfesseur($form['idProfesseur']->getData());
                $group->setIdMatiere($form['idMatiere']->getData());
                $group->setHDebut($form['hDebut']->getData());
                $group->setHFin($form['hFin']->getData());
                $group->setEffectuer($form['effectuer']->getData());
                $group->setSalle($form['salle']->getData());
                $group->setDtdebut($form['dtdebut']->getData());
                $group->setDtfin($form['dtfin']->getData());
                $entityManager->persist($group);
            }
            $entityManager->flush();


            return $this->redirectToRoute('seance_index');
        }

        return $this->render('seance/new.html.twig', [
            'seance' => $seance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idSeance}", name="seance_show", methods={"GET"})
     * @param Seance $seance
     * @return Response
     */
    public function show(Seance $seance): Response
    {
        return $this->render('seance/show.html.twig', [
            'seance' => $seance,
        ]);
    }

    /**
     * @Route("/{idSeance}/edit", name="seance_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Seance $seance
     * @return Response
     */
    public function edit(Request $request, Seance $seance): Response
    {
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('seance_index');
        }

        return $this->render('seance/edit.html.twig', [
            'seance' => $seance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idSeance}", name="seance_delete", methods={"DELETE"})
     * @param Request $request
     * @param Seance $seance
     * @return Response
     */
    public function delete(Request $request, Seance $seance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seance->getIdSeance(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($seance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('seance_index');
    }
}
