<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\TypeArticle;
use App\Entity\UniteArticle;
use App\Form\TypeArticleType;
use App\Form\UniteArticleType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleController extends AbstractController
{
    /**
     * @Route("/ajouterArticle", name="ajouterArticle")
     */
    public function article(Request $request,ObjectManager $manager){
        $article=new Article();

        $form=$this->createForm(ArticleType::class, $article);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

        //  $val=$article->getQuantiteStock();
        //  $article->setQuantiteStock($val=0);
         

         $article->setEtat(0);
         $article->setSituation('Actif');

         $manager->persist($article);
         $manager->flush();       
         
         $this->addFlash(
             'info',
             'Ajouté avec Succès'
         );
      }

        return $this->render('article/ajouterArticle.html.twig', [
        'form' => $form->createView()
    ]
  );
 }
     /**
     * @Route("/ajouterTypeArticle", name="ajouterTypeArticle")
     */
    public function ajouterTypeArticle(Request $request,ObjectManager $manager)
    {
        $typeArticle=new TypeArticle();

        $form=$this->createForm(TypeArticleType::class, $typeArticle);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
         $manager->persist($typeArticle);
         $manager->flush();       
         
         $this->addFlash(
             'info',
             'Ajouté avec Succès'
         );
      }
        return $this->render('article/ajouterTypeArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/ajouterUniteArticle", name="ajouterUniteArticle")
     */
    public function ajouterUniteArticle(Request $request,ObjectManager $manager)
    {
        $uniteArticle=new UniteArticle();

        $form=$this->createForm(UniteArticleType::class, $uniteArticle);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

          
         $manager->persist($uniteArticle);
         $manager->flush();       
         
         $this->addFlash(
             'info',
             'Ajouté avec Succès'
         );
      }
        return $this->render('article/ajouterUniteArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //Gestion Blocage et Deblocage
      

      /**
       * @Route("/bloquerArticle/{id}", name="bloquerArticle")
       */
      public function bloquer($id, Request $request, ObjectManager $manager){
        $article = $this->getDoctrine()
        ->getRepository(Article::class)
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
       return $this->redirectToRoute('afficherArticle');
     }

     /**
       * @Route("/debloquerArticle/{id}", name="debloquerArticle")
       */
      public function debloquer($id, Request $request, ObjectManager $manager){
        $article = $this->getDoctrine()
        ->getRepository(Article::class)
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
       return $this->redirectToRoute('afficherArticle');
     }

     /**
     * @Route("/afficherArticle", name="afficherArticle")
     */
    public function afficherArticle(){

        $article = $this->getDoctrine()
        ->getRepository(Article::class)
        ->findAll();

        // $debloq=1;
        // $article2 = $this->getDoctrine()
        // ->getRepository(Article::class)
        // ->findDebloqueArticle($debloq);
      
        return $this->render('article/afficherArticle.html.twig',[
            'article' => $article  
        ]);
       }
  
     /**
       * @Route("/article/{id}", name="article")
       */
      public function modifier($id, Request $request){
        $fournisseur = new Article();
        $fournisseur = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $form = $this->createFormBuilder($fournisseur)
        ->add('NomArticle', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('Designation', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('AlerteStock', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('QuantiteStock', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('types', EntityType::class, array(
            'attr' => array('class' => 'form-control'),
            'class' => 'App:TypeArticle'
            ))  
        ->add('unites', EntityType::class, array(
          'attr' => array('class' => 'form-control'),
          'class' => 'App:UniteArticle'
          ))
          
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('afficherArticle');
        }
        return $this->render('article/modifierArticle.html.twig', array(
          'form' => $form->createView()
        ));
      }


      //  A voir
      // https://symfonycasts.com/screencast/doctrine-relations/many-to-many
  
       

     
     
}
