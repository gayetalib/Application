<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ServiceType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Service;
use Proxies\__CG__\App\Entity\Departement;

class ServiceController extends AbstractController
{
     /**
     * @Route("/ajouterService", name="ajouterService")
     */
    public function direction(Request $request,ObjectManager $manager){
        $service=new Service();

        $form=$this->createForm(ServiceType::class, $service);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
         $manager->persist($service);
         
         $this->addFlash(
            'info',
            'Ajouté avec Succès'
          );
         $manager->flush();  
            
      }
      return $this->render('service/ajouterService.html.twig', [
        'form' => $form->createView()
    ]
  );
   }

   /**
     * @Route("/afficherService", name="afficherService")
     */
    public function afficherService(){
      $fournisseur = $this->getDoctrine()
      ->getRepository(Service::class)
      ->findAll();

      return $this->render('service/afficherService.html.twig',[
          'service' => $fournisseur 
       ]);
     }

   /**
     * @Route("/service/{id}", name="service")
     */
    public function modifier($id, Request $request){
      $service = new Service();
      $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
      $form = $this->createFormBuilder($service)
        ->add('NomService', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('departements', EntityType::class, array(
          'attr' => array('class' => 'form-control'),
          'class' => 'App:Departement'
          ))
        // ->add('directions', EntityType::class, array(
        //   'attr' => array('class' => 'form-control'),
        //   'class' => 'App:Direction'
        //   ))
               
        ->getForm();
        
       $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('afficherService');
      }
      return $this->render('service/modifierService.html.twig', array(
        'form' => $form->createView()
      ));
    }

     /**
     * @Route("/supprimerService/{id}", name="supprimerService")
     */
    public function supprimer($id, Request $request, ObjectManager $manager){
      $fournisseur = $this->getDoctrine()
      ->getRepository(Service::class)
      ->find($id);
       
      $manager->remove($fournisseur);
      $manager->flush(); 
      
      // $response = new Response();
      // $response->send();
      
      return $this->redirectToRoute('afficherService');
   }
}
