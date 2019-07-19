<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Response;

class FournisseurController extends AbstractController
{
   /**
     * @Route("/ajouterFournisseur", name="ajouterFournisseur")
     */
    public function fournisseur(Request $request,ObjectManager $manager){
        $fournisseur=new Fournisseur();

        $form=$this->createForm(FournisseurType::class, $fournisseur);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
         $manager->persist($fournisseur);
         $manager->flush();

         $this->addFlash(
            'info',
            'Ajouté avec Succès'
          );
      }
      return $this->render('fournisseur/ajouterFournisseur.html.twig', [
        'form' => $form->createView()
    ]
   );
  }

   /**
     * @Route("/afficherFournisseur", name="afficherFournisseur")
     */
    public function afficherFournisseurr(){
      $fournisseur = $this->getDoctrine()
      ->getRepository(Fournisseur::class)
      ->findAll();

      return $this->render('fournisseur/afficherFournisseur.html.twig',[
          'user' => $fournisseur
      ]);
     }

   /**
     * @Route("/fournisseur/{id}", name="fournisseur")
     */
    public function modifier($id, Request $request){
      $fournisseur = new Fournisseur();
      $fournisseur = $this->getDoctrine()->getRepository(Fournisseur::class)->find($id);
      $form = $this->createFormBuilder($fournisseur)
        ->add('NomFournisseur', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('numeroFournisseur', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('AdresseFournisseur', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('MailFournisseur', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('BoitePostale', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('Fax', TextType::class, array('attr' => array('class' => 'form-control')))
               
        ->getForm();
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('afficherFournisseur');
      }
      return $this->render('fournisseur/modifierFournisseur.html.twig', array(
        'form' => $form->createView()
      ));
    }

     /**
     * @Route("/supprimerFournisseur/{id}", name="supprimerFournisseur")
     */
    public function supprimer($id, Request $request, ObjectManager $manager){
      $fournisseur = $this->getDoctrine()
      ->getRepository(Fournisseur::class)
      ->find($id);
       
      $manager->remove($fournisseur);
      $manager->flush(); 
      
      $response = new Response();
      $response->send();
      
      return $this->redirectToRoute('afficherFournisseur');
   }

   /**
       * @Route("/bloquerFournisseur/{id}", name="bloquerFournisseur")
       */
      public function bloquer($id, Request $request, ObjectManager $manager){
        $article = $this->getDoctrine()
        ->getRepository(Fournisseur::class)
        ->find($id);
        
        
         //Initialiser etat a 1
        $article->setEtat(1);
        $article->setSituation('Bloqué');
    
        // $manager->remove($article);
        $manager->flush(); 
  
             
      //   return $this->render('article/afficherArticle.html.twig',[
      //     'article' => $article,
      //      'etat' => $article->getEtat()
      // ]);
       return $this->redirectToRoute('afficherFournisseur');
     }

     /**
       * @Route("/debloquerArticle/{id}", name="debloquerArticle")
       */
      public function debloquer($id, Request $request, ObjectManager $manager){
        $article = $this->getDoctrine()
        ->getRepository(Fournisseur::class)
        ->find($id);
        
        
         //Initialiser etat a 1
        $article->setEtat(0);
        $article->setSituation('Actif');
        // $manager->remove($article);
        $manager->flush(); 
  
             
      //   return $this->render('article/afficherArticle.html.twig',[
      //     'article' => $article,
      //      'etat' => $article->getEtat()
      // ]);
       return $this->redirectToRoute('afficherFournisseur');
     }

}
