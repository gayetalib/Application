<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\DepartementType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Departement;
use Symfony\Flex\Response;

class DepartementController extends AbstractController
{
   /**
     * @Route("/ajouterDepartement", name="ajouterDepartement")
     */
    public function departement(Request $request,ObjectManager $manager){
        $departement=new Departement();

        $form=$this->createForm(DepartementType::class, $departement);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
         $manager->persist($departement);
         $manager->flush();       

         $this->addFlash(
            'info',
            'Ajouté avec Succès'
          );
          
       }
      return $this->render('departement/ajouterDepartement.html.twig', [
        'form' => $form->createView()
    ]
  );
   }

   

}
