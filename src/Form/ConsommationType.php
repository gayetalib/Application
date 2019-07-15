<?php

namespace App\Form;

use App\Form\ArticleRepository;
use App\Entity\Consommation;
use Symfony\Component\Form\AbstractType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;

class ConsommationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder    
            ->add('DateConsommation')
            ->add('services',EntityType::class,[
                'class' => 'App:Service',
                'placeholder' => '-Choisir un service-'
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
            ->add('QuantiteCons')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consommation::class,
        ]);
    }
}
