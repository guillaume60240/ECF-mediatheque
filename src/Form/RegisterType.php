<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Votre prénom *',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre prénom'
                ]
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Votre nom *',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Votre email *',
                'constraints' => new Length([
                    'min' => 5,
                    'max' => 60
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir un email valide'
                ]
            ])
            ->add('birthday', DateType::class, [
                'required' => true,
                'label' => 'Votre date de naissance *'
            ])
            ->add('street', TextType::class, [
                'required' => true,
                'mapped' =>false,
                'label' => 'Votre adresse *', 
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 60
                ]),
                'attr' => [
                    'placeholder' => 'n° et nom de rue'
                ]
            ])
            -> add('city', TextType::class, [
                'required' => true,
                'mapped' => false,
                'label' => 'Votre ville *',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 60
                ]),
                'attr' => [
                    'placeholder' => 'Ville de résidence'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Vos mots de passe ne correspondent pas',
                'required' => true,
                'first_options' => [
                    'label' => 'Votre mot de passe *',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre mot de passe'
                    ]],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe *',
                    'attr' => [
                        'placeholder' => 'Merci de confirmer votre mot de passe'
                    ]],
            ])
            ->add('checkbox', CheckboxType::class, [
                'mapped' => false,
                'required' => true,
                'label' => "En m'inscrivant j'accepte le règlement du site"
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider"
            ])

            ->add('delete', ResetType::class, [
                'label' => "Annuler"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
