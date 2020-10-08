<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    /**
     * @Route("/notification", name="notification")
     */
    public function index()
    {
        $notification = $this->getDoctrine()
        ->getRepository(Notification::class)
        ->read();
        return $this->render('notification/index.html.twig', [
            'controller_name' => 'NotificationController',
            'notification' => $notification,
        ]);
    }
    /**
     * @Route("/notification/show", name="notification_show", methods={"GET"})
     * @param Notification $notification
     * @return Response
     */
    public function show(Notification $notification): Response
    {
        return $this->render('base.html.twig', [
            'notification' => $notification,
        ]);
    }
}
