<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\Eleve;
use App\Form\AbsenceType;
use App\Form\AbsentPresentType;

use App\Form\NewAbsenceType;
use App\Repository\EleveRepository;

use App\Repository\AbsenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface ;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


/**
 * @Route("/absenceleve")
 */
class AbsenceController extends AbstractController
{
    /**
     * @Route("/", name="absence_index")
     */
    public function index(AbsenceRepository $absenceRepository, Request $request): Response
    {
        $search = new Absence();
        $form=$this->createForm(AbsenceType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
    // ... perform some action, such as saving the task to the database

    $nextAction = $form->get('add')->isClicked()
        ? 'absence_new'
        : 'absence_index';
        

    return $this->redirectToRoute($nextAction);
}
    
        return $this->render('absence/index.html.twig', [
'absence' => $absenceRepository->findAll(),
            'form'=>$form->createView()        
        ]);
    }

 
   /**
     * @Route("/new", name="absence_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(EleveRepository $em,Request $request,EntityManagerInterface $mng): Response
    {
        $absence = new Eleve();
        $idNiveau = $request->query->get('id_niveau', null);
        if ($request->isMethod('POST')) {
            $idNiveau = $request->request->get('id_niveau', null);
        }
        $idMatier = $request->query->get('id_matiere', null);
        if ($request->isMethod('POST')) {
            $idMatier = $request->request->get('id_matiere', null);
        }
        
        $form = $this->createForm(NewAbsenceType::class,$absence,  [
            'id_matiere' => $idMatier,
            'id_niveau' => $idNiveau
        ]);
        $form->handleRequest($request);

        $secondform = $this->createForm(AbsentPresentType::class);
        $secondform->handleRequest($request);
       $eleves = [];
        if ($form->isSubmitted() && $form->isValid()) {
        $eleves = $em->findeleve($form->get('niveau')->getData()->getNiveau() , $form->get('niveau')->getData()->getEmail());
        }
        

           if ($secondform->isSubmitted() && $secondform->isValid()) {
        if (!empty($_POST['All'])) {
              return $this->redirectToRoute('absence_index');
              }
          
          for ($i=1 ; $i <= count($eleves) ; $i++) { 
          	$k = $i-1 ;
         
        if(empty($_POST[$i]))  { 

            $abs = new Absence;
            $data = $form->getData();
            $id = $eleves[$k];
           
            $abs->setIdEleve($id);
            $abs->setDate($data['date']);
            $abs->setMatiere($data['matiere']);
            $abs->setProf($data['professeur']);
            $mng->persist($abs);
            $mng->flush();  
           }
            }
              return $this->redirectToRoute('absence_index');
       
         }
                 return $this->render('absence/new.html.twig',[
         	
         	'eleves' => $eleves, 
            'form2' => $secondform->createView(),
            'form' => $form->createView(),

        ]);

     


      /*  if ($secondform->isSubmitted() && $secondform->isValid()) {
                   
        dd($form->getData());
        if (!empty($_POST['All'])) {
              return $this->redirectToRoute('absence_index');
              }
/*            $eleves = $em->findBy(array('nom' => 'saha'), null,null,null);
     dd($form->getData(),$secondform->getData());
     
     }
       */  
         

        /*return $this->render('absence/_form.html.twig', [
            'form' => $form->createView()
        ]);*/
    }
    
}