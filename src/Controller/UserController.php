<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
// use App\Controller\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserController extends AbstractController
{
    /**
     * @Route("/ajouterUser", name="ajouterUser")
     */
    public function formAjouterUser(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
        
        $user=new User();

        $form=$this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
    
         $role = $form->get('roles')->getData();
         $user->setRoles($role);
        

         $hash= $encoder->encodePassword($user, $user->getPassword());   
         $user->setPassword($hash);
         
         $manager->persist($user);
         $manager->flush();     
         
         $this->addFlash(
            'info',
            'Ajouté avec Succès'
        );   
         
        }
        return $this->render('user/ajouterUser.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/afficherUser", name="afficherUser")
     */
     public function afficherUser(){
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();

        return $this->render('user/afficherUser.html.twig',[
            'user' => $user
        ]);
     }

     /**
     * @Route("/user/{id}", name="user")
     */
     public function modifier($id, Request $request){
      $user = new User();
      $user = $this->getDoctrine()->getRepository(User::class)->find($id);
      $form = $this->createFormBuilder($user)
        ->add('nom', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('prenom', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('matricule', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('email', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('username', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('password', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('roles', ChoiceType::class,[
          'choices' => [
              'User' => 'ROLE_USER',
              'Admin' => 'ROLE_ADMIN',
              'Super Admin' => 'ROLE_SUPER_ADMIN',
            ]
          ])
       
        ->getForm();
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('afficherUser');
      }
      return $this->render('user/modifierUser.html.twig', array(
        'form' => $form->createView()
      ));
    }
 
    
     /**
     * @Route("/supprimerUser/{id}", name="supprimerUser")
     */
    public function supprimer($id, Request $request, ObjectManager $manager){
        $user = $this->getDoctrine()
        ->getRepository(User::class) 
        ->find($id);
         
        $manager = $this->getDoctrine()->getManager();
        
        $manager->remove($user);
        $manager->flush(); 
        
        $response = new Response();
        $response->send();

        return $this->redirectToRoute('afficherUser');
     }
}
