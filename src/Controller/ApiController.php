<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\Seance;
use App\EventSubscriber\CalendarSubscriber;
use http\Env\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route ("/api/{id}/edit",name="api_event_edit",methods={"PUT"})
     */
    public function majEvent(?Seance $calendar,Request $request){
        $donnees=json_encode($request->getContent());
        if(
            isset($donnees->title) && !empty($donnees->title)&&
            isset($donnees->start) && !empty($donnees->start)&&
            isset($donnees->end) && !empty($donnees->end)&&
            isset($donnees->description) && !empty($donnees->description)
        ){
            $code=200;
            if(!$calendar) {
                $calendar = new Seance;
                $code = 201;
            }
                $test=explode(" ",$donnees->title);
                $calendar->setSalle($test[0]);
                $calendar->setIdMatiere($test[1]);
                $calendar->setIdProfesseur($test[2]);
                $test1=explode(" ",$donnees->start);
                $calendar->setJour($test1[0]);
                $calendar->setHDebut($test1[1]);
                $test2=explode(" ",$donnees->description);
                $calendar->setEffectuer($test2[0]);
                $test3=explode(" ",$donnees->end);
                $calendar->setHFin($test3[1]);
                $em=$this->getDoctrine()->getManager();
                $em->persist($calendar);
                $em->flush();
                return new Response('Ok',$code);

        }else{
            return new Response('Donnees incompletes',404);
        }
        return $this->render('api/index.html.twig',[
           'controller_name'=>'ApiController',
        ]);
    }
}
