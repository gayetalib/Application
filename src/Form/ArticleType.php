<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\IntegerType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NomArticle')
            ->add('Designation')
            ->add('QuantiteStock')
            ->add('AlerteStock')
            ->add('types',EntityType::class,[
                'class' => 'App:TypeArticle',
                'placeholder' => '-Choisir le type de l"article-'
            ])
            ->add('unites',EntityType::class,[
                'class' => 'App:UniteArticle',
                'placeholder' => '-Choisir l"unite de l"article-'
            ])
            // ->add('situation')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
