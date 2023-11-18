<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\Personne;
use App\Entity\Profile;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('name')
            ->add('age')
            ->add('profile', EntityType::class, [
                'expanded' => true,
                'class' => Profile::class,
                'multiple' => false,
                'required' => false,
                'attr'=>[
                    'class'=>'select2'
                    ]
            ])
            ->add('hobbies')
            ->add('job', EntityType::class, [
                'required'=>false,
                'class'=>Job::class,
                'attr'=>[
                    'class'=>'select2'
                    ]
                ])
            ->add('Photo', FileType::class, [
                'label'=>'Votre image de profil (Des fichier images Uniquement)',
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new File([
                        'maxSize'=>'1024k',
                        'mimeTypes'=>[
                            'image/gif',
                            'image/jpeg',
                            'image/Jpg',
                            
                    ],
                        'mimeTypesMessage'=>'please upload à valid Pdf document'],
                        )
                ]
            ])
            ->add('editer',type:SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
