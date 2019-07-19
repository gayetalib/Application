<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Consommation;
use App\Form\ConsommationType;
use Symfony\Component\Form\FormTypeInterface;
use App\Form\ApprovisionnementType;
// use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Approvisionnement;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use phpDocumentor\Reflection\Types\Integer;
use App\Entity\Article;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Component\Console\Application;
use Symfony\Bundle\FrameworkBundle\Console\Application as SymfonyApplication;

class GestionController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('gestion/index.html.twig', [
            'controller_name' => 'GestionController',
        ]);
    }

    /**
     * @Route("/ajouterConsommation", name="ajouterConsommation")
     */
    public function formAjouterCons(Request $request, ObjectManager $manager){
        
        $cons=new Consommation();

        $form=$this->createForm(ConsommationType::class, $cons);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           
          //recuperer la quantite stockee pour l'article : initiale 0
          $val1=$cons->getArticles()->getQuantiteStock();
          //La valeur approvisionnee actuellement
          $val2=$cons->getQuantiteCons();
          //La difference
          $val=$val1-$val2;

          //Update la valeur stockee
          $cons->getArticles()->setQuantiteStock($val);


         $manager->persist($cons);     
         $manager->flush();    
         
         $this->addFlash(
            'info',
            'Ajouté avec Succès'
         );   
         
        }
        return $this->render('consommation/ajouterConsommation.html.twig', [
            'form' => $form->createView()
        ]);
     }

    /**
     * @Route("/afficherConsommation", name="afficherConsommation")
     */
     public function afficherCons(){
        $cons = $this->getDoctrine()
        ->getRepository(Consommation::class)
        ->findAll();

        return $this->render('consommation/afficherConsommation.html.twig',[
            'cons' => $cons
        ]);
     }

     /**
     * @Route("/cons/{id}", name="modifierCons")
     */
     public function modifier($id, Request $request){
      $cons = new Consommation();
      $user = $this->getDoctrine()->getRepository(Consommation::class)->find($id);
      $form = $this->createFormBuilder($user)
        ->add('DateConsommation', DateTimeType::class, array('attr' => array('class' => 'form-control')))
        ->add('services',EntityType::class, [
            'class' => 'App:Service',
            'placeholder' => '-Choisir un service-'
        ])
        ->add('articles',EntityType::class, [
            'class' => 'App:Article',
            'placeholder' => '-Choisir un aricle-'
        ])
        ->add('QuantiteCons', TextType::class, array('attr' => array('class' => 'form-control')))   
        ->getForm();

        //Traitement
        

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
       
        //recuperer la quantite stockee pour l'article : initiale 0
        $val1=$cons->getArticles()->getQuantiteStock();
        //La valeur approvisionnee actuellement
        $val2=$cons->getQuantiteCons();
        //La difference
      
        $val=$val1-$val2;

        //Update la valeur stockee
        $cons->getArticles()->setQuantiteStock($val);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('afficherConsommation');
      }
      return $this->render('consommation/modifierConsommation.html.twig', array(
        'form' => $form->createView()
      ));
    }
 
     /**
     * @Route("/supprimerCons/{id}", name="supprimerCons")
     */
    public function supprimer($id, Request $request, ObjectManager $manager){
        $user = $this->getDoctrine()
        ->getRepository(Consommation::class)
        ->find($id);
         
        $manager = $this->getDoctrine()->getManager();

        //recuperer la quantite stockee pour l'article : initiale 0
        $val1=$user->getArticles()->getQuantiteStock();
        //La valeur approvisionnee actuellement
        $val2=$user->getQuantiteCons();
        //La difference
      
        $val=$val1+$val2;

        //Update la valeur stockee
        $user->getArticles()->setQuantiteStock($val);

        
        $manager->remove($user);
        $manager->flush(); 

        return $this->redirectToRoute('afficherConsommation');
     }      

     /**
     * @Route("/ajouterApprov", name="ajouterApprov")
     */
    public function formAjouterApprov(Request $request, ObjectManager $manager){
  
        $approv=new Approvisionnement();

        $cons=$this->createForm(ApprovisionnementType::class, $approv);
        
        $cons->handleRequest($request);
        
        if($cons->isSubmitted() && $cons->isValid()){
              
          //recuperer la quantite stockee pour l'article : initiale 0
          $val1=$approv->getArticles()->getQuantiteStock();
          //La valeur approvisionnee actuellement
          $val2=$approv->getQuantiteApprov();
          //La somme
          $val=$val1+$val2;

          //Update la valeur stockee
          $approv->getArticles()->setQuantiteStock($val);

         $manager->persist($approv);
         $manager->flush();    
         
         $this->addFlash(
            'info',
            'Ajouté avec Succès'
        );   
         
        }
      return $this->render('approv/ajouterApprov.html.twig', [
            'form' => $cons->createView()

        ]); 
     }

    /**
     * @Route("/afficherApprov", name="afficherApprov")
     */
     public function afficherApprov(){
        $cons = $this->getDoctrine()
        ->getRepository(Approvisionnement::class)
        ->findAll();

        return $this->render('approv/afficherApprov.html.twig',[
            'cons' => $cons
        ]);
     }

     /**
     * @Route("/approv/{id}", name="approv")
     */
     public function modifierApprov($id, Request $request){
      $user = new Approvisionnement();
      $user = $this->getDoctrine()->getRepository(Approvisionnement::class)->find($id);
      $form = $this->createFormBuilder($user)
        ->add('NumeroCommande')
        ->add('DateEntree', DateTimeType::class, array('attr' => array('class' => 'form-control')))
        ->add('articles',EntityType::class, [
            'class' => 'App:Article',
            'placeholder' => '-Choisir un aricle-'
        ])
        ->add('QuantiteApprov', TextType::class, array('attr' => array('class' => 'form-control')))  
        ->add('fournisseurs',EntityType::class, [
            'class' => 'App:Fournisseur',
            'placeholder' => '-Choisir un forunissuer-'
        ]) 
        ->getForm();
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {

        //recuperer la quantite stockee pour l'article : initiale 0
        $val1=$user->getArticles()->getQuantiteStock();
        //La valeur approvisionnee actuellement
        $val2=$user->getQuantiteApprov();
        //La somme
        $val=$val1+$val2;

        //Update la valeur stockee
        $user->getArticles()->setQuantiteStock($val);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('afficherApprov');
      }
      return $this->render('approv/modifierApprov.html.twig', array(
        'form' => $form->createView()
      ));
    }
 
     /**
     * @Route("/supprimerApprov/{id}", name="supprimerApprov")
     */
    public function supprimerApprov($id, Request $request, ObjectManager $manager){
        $user = $this->getDoctrine()
        ->getRepository(Approvisionnement::class)
        ->find($id);
         
        $manager = $this->getDoctrine()->getManager();

        //recuperer la quantite stockee pour l'article : initiale 0
        $val1=$user->getArticles()->getQuantiteStock();
        //La valeur approvisionnee actuellement
        $val2=$user->getQuantiteApprov();
        //La difference
      
        $val=$val1-$val2;

        //Update la valeur stockee
        $user->getArticles()->setQuantiteStock($val);
        
        $manager->remove($user);
        $manager->flush(); 
        
        // $response = new Response();
        // $response->send();

        return $this->redirectToRoute('afficherApprov');
     }    





     

}
