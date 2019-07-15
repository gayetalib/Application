<?php

namespace App\Form;

use App\Entity\User;
use Acme\TestBundle\Form\DataTransformer\StringToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
// use PhpParser\Node\Expr\Cast\String_;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $transformer = new StringToArrayTransformer();
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('Matricule')
            ->add('Email')
            ->add('username')
            ->add('password')
            ->add('roles', ChoiceType::class,[
                'data_class' => null,
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'Super Admin' => 'ROLE_SUPER_ADMIN',
                ],
            ])
            // ->addModelTransformer($transformer);

        // StringToArrayTransformer(roles);
           
        // $builder->get('roles')
           
            // ->addModelTransformer(new CallbackTransformer(
            //     function ($roles) {
            //         // transform the array to a string
            //         return implode(', ', (array)$roles);
            //     },
            //     function ($roles) {
            //         // transform the string back to an array
            //         return explode(', ', (string)$roles);
            //     }
            // ))
        ;

        //roles field data transformer
// $builder->get('roles')
// ->addModelTransformer(new CallbackTransformer(
//     function ($rolesArray) {
//          // transform the array to a string
//          return count($rolesArray)? $rolesArray[0]: null;
//     },
//     function ($rolesString) {
//          // transform the string back to an array
//          return [$rolesString];
//     }
// ));
    
    //roles field data transformer
    // $builder->get('roles')
    //     ->addModelTransformer(new CallbackTransformer(
    //         function ($rolesArray) {
    //              // transform the array to a string
                 
    //              return count($rolesArray)? $rolesArray[0]: null;
    //         },
    //         function ($rolesString) {
    //              // transform the string back to an array
    //              return [$rolesString];
    //         }
    // ));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
