<?php

namespace App\Form;

use App\Entity\Enterprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('siret', TextType::class, [
                'label' => 'Siret',
                'attr' => [
                    'placeholder' => 'Votre numero de siret',
                    'class' => 'my-2'
                ]
            ])
            ->add('raisonsociale', TextType::class, [
                'label' => 'Entreprise',
                'attr' => [
                    'placeholder' => 'Votre nom d\'entreprise',
                    'class' => 'my-2'
                ]
            ])
            ->add('datecreation', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de creation',
                'attr' => [
                    'class' => 'my-2'
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Votre adresse d\'entreprise',
                    'class' => 'my-2'
                ]
            ])
            ->add('codepostale', TextType::class, [
                'label' => 'Code Postale',
                'attr' => [
                    'placeholder' => 'Votre code postale d\'entreprise',
                    'class' => 'my-2'
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Votre ville d\'entreprise',
                    'class' => 'my-2'
                    
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enterprise::class,
        ]);
    }
}
