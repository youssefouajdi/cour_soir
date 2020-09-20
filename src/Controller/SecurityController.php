<?php

namespace App\Controller;

use App\Form\UserRegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Swift_SmtpTransport;
use Swift_Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    public const LAST_EMAIL='app_login_form_old_email';
    /**
     *
     * @Route("/login", name="app_login" , methods={"GET","POST"})
     */
    public function index()
    {
        return $this->render('security/login.html.twig');
    }
    /**
     *
     * @Route("/logout", name="app_logout" , methods={"GET"})
     */
    function logout(){
        throw new LogicException('This method can be blank it will be intercepted by the logout');
    }

    /**
     *
     * @Route("/register", name="app_register" , methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param \Swift_Mailer $mailer
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function register(Request  $request ,EntityManagerInterface $em,\Swift_Mailer  $mailer,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form=$this->createForm(UserRegistrationFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() &&$form->isValid()){
            $user=$form->getData();
            $plainPassword=$form['plainPassword']->getData();
            $user->setPassword($passwordEncoder->encodePassword($user, $plainPassword));
            $a=[];
            array_push($a,$form['roles']->getData());
            $user->setRoles($a);
            $em->persist($user);
            $em->flush();
            unset($a);
            $this->addFlash('success','creer avec succes');
            // Create the Transport
            $transport = (new Swift_SmtpTransport('smtp.googlemail.com', 465, 'ssl'))
            ->setUsername('smtpgmail')
            ->setPassword('smtppassword')
        ;

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
            $message=(new \Swift_Message('Nouveau utilisateur'))
                ->setFrom('youssefouajdi1@gmail.com')
                ->setTo($form['email']->getData())
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig',array('user' => $user,
                        'password'=>$plainPassword)
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $this->addFlash('message', 'le message a bien ete envoye');

            /*ici l envoi d email */
            return $this->redirectToRoute('matiere_index');
        }
        return $this->render('security/register.html.twig',[
            'registrationForm'=>$form->createView()
        ]);
    }

}
