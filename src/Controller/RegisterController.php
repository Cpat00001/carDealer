<?php

namespace App\Controller;

//user entity
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
//bring request
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

// input types
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
//passwordHasher
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request , UserPasswordHasherInterface $passwordHasher): Response
    {
        // user from entity
        $user = new User();
        // form 
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, [ 'label' => 'User'])
            ->add('password', RepeatedType::class, [ 
                'type' => PasswordType::class,
                'invalid_message' => 'The password must match',
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'], 
                ])
            ->add('save', SubmitType::class, ['label' => 'Create Profile'])
            ->getForm();

            // processing submitted data and form
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $data_user = $form->getData();
              //username
              $user->setUsername($data_user->getUsername());
              //var_dump($user);
              //password
              $user->setPassword(
                //$passwordHasher->hashPassword($user,$data_user['password']->getData())
                $passwordHasher->hashPassword($user,$data_user->getPassword())
              );

              //entity Manager 
              $entityManager = $this->getDoctrine()->getManager();
              //tell doctrine you want to save data to Table User
              $entityManager->persist($user);
              //save data in User Table
              $entityManager->flush();

            //   return new Response('Saved new User with id '.$user->getUserIdentifier());
               
                // redirect after form submission
                return $this->redirectToRoute('home');
            }

        return $this->render('register/form.html.twig', [
            'form' => $form->createView(),
            'name' => 'Registration Form',
        ]);
    }
}
