<?php

namespace App\Controller;
use App\Entity\Seance;
use App\Form\SeanceType;
use App\Repository\SeanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/seance")
 */
class SeanceController extends AbstractController
{
    /**
     * @Route("/", name="seance_index", methods={"GET"})
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
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $seance = new Seance();

        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $seance=$form->getData();
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
            for($i=0;$i<$k;$i++){
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "coursdusoir";
                $conn = new \mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $inf=$form['idMatiere']->getData();
                $inf1=$form['idProfesseur']->getData();
                $inf2=$form['dtdebut']->getData();
                $inf3    =$form['dtfin']->getData();
                $inf4=$form['hDebut']->getData();
                $inf5=$form['hFin']->getData();
                $inf6=   $form['salle']->getData()->format('H:i:s');
                $inf7=$form['effectuer']->getData();
                $sql = "INSERT INTO `seance`( `id_matiere`, `id_professeur`, `dtdebut`, `dtfin`, `h_debut`, `h_fin`, `salle`, `effectuer`, `jour`)
                VALUES ($inf,$inf1,$inf2,$inf3,$inf4,$inf5,$inf6,$inf7,$a[$i]->format('Y-m-d'))";
                $conn->query($sql);

            $conn->close();
            }



            return $this->redirectToRoute('seance_index');
        }

        return $this->render('seance/new.html.twig', [
            'seance' => $seance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idSeance}", name="seance_show", methods={"GET"})
     */
    public function show(Seance $seance): Response
    {
        return $this->render('seance/show.html.twig', [
            'seance' => $seance,
        ]);
    }

    /**
     * @Route("/{idSeance}/edit", name="seance_edit", methods={"GET","POST"})
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
