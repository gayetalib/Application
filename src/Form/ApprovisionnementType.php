<?php

namespace App\Form;

use App\Entity\Approvisionnement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ApprovisionnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
        $builder
            ->add('NumeroCommande')
            ->add('DateEntree')
            ->add('fournisseurs',EntityType::class,[
                'class' => 'App:Fournisseur',
                'placeholder' => '-Choisir un fournisseur-'
            ])
            
            ->add('articles',EntityType::class,[
                'class' => 'App:Article',
                'query_builder' => function (EntityRepository $article) {
                    return $article->createQueryBuilder('a')
                    ->andWhere('a.etat = 0')
                    ->orderBy('a.etat', 'ASC')
                    ;
   
                },
                'placeholder' => '-Choisir un article-'
            ])
            
           ->add('QuantiteApprov');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Approvisionnement::class,
        ]);
    }
}
