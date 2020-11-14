<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="register")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function register(Request $request,
                             EntityManagerInterface $em,
                            UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        //$user->setDateCreated(new\DateTime());

        $registerForm = $this->createForm(UserType::class, $user);


        $registerForm->handleRequest($request);
        if($registerForm->isSubmitted() && $registerForm->isValid()){
            // hasher le mot de passe
            $hashed = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashed);

            $em->persist($user);
            $em->flush();

            /**
             * @todo: redoiriger l'utilisateur vers la page d'accueil
             */
            return $this->redirectToRoute('home', []);

        }
        return $this->render('user/register.html.twig', [
            'registerForm'=>$registerForm->createView(),
        ]);
    }

}
