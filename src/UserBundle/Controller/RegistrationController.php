<?php

namespace UserBundle\Controller;

use UserBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use AppBundle\Entity\User as User;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends Controller
{

    public function registerAction(Request $request)
    {
        // if ($this->getUser()) {
        //     return $this->redirect($this->generateUrl('fos_user_profile_show', array()));
        // }
        return $this->redirectToRoute('fos_user_security_login');
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)

            // 4) save the User!
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('fos_user_security_login');
        }

        return $this->render(
            'FOSUserBundle:Registration:register.html.twig',
            array('form' => $form->createView())
        );
    }
}

?>