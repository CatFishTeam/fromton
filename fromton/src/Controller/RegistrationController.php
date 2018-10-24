<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use App\Events;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use DateTime;

class RegistrationController extends Controller
{

    private $mailer;
    private $sender;

    /**
     * RegistrationController constructor.
     * @param Swift_Mailer $mailer
     * @param $sender
     */
    public function __construct(Swift_Mailer $mailer, $sender)
    {
        $this->mailer = $mailer;
        $this->sender = $sender;
    }


    /**
     * @Route("/register", name="user_registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, EventDispatcherInterface $eventDispatcher)
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // Par defaut l'utilisateur aura toujours le rôle ROLE_USER
            $user->setRoles(['ROLE_USER']);
            $user->setValidate(false);
            $user->setXp(1);
            $dateNow = new DateTime;
            $dateNow->getTimestamp();
            $user->setCreatedAt($dateNow);
            $user->setToken(md5(random_bytes(20)));

            // On enregistre l'utilisateur dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->sendEmail($user);

            return $this->redirectToRoute('security_login');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/register/validate", name="user_registration_validate")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validate(Request $request)
    {
        $em= $this->getDoctrine()->getManager();

        $userId = $request->get('userId');
        $token = $request->get('token');

        if (isset($userId, $token)) {
            /** @var User $user */
            $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('userId'));

            if ($user->getToken() == $request->get('token')) {
                $user->setValidate(true);
                $em->flush();

                $this->addFlash(
                    'info',
                    'Votre compte est bien valide !'
                );

                return $this->redirectToRoute('home');
            }
        } else {
            $this->addFlash(
                'notice',
                'Erreur'
            );

            return $this->redirectToRoute('home');
        }

    }

    private function sendEmail(User $user) {

        $subject = "[FROMTON] Validez votre inscription";

        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setTo($user->getEmail())
            ->setFrom($this->sender)
            ->setBody(
                $this->render(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    array('user' => $user)
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}