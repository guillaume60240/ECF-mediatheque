<?php

namespace App\Form;

use App\Entity\Validation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ValidationMailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class,[
                'label' => 'Code de 4 chiffres reçu par mail*',
                'required' => true,
                'constraints' => new Length(4),
                'attr' => [
                    'placeholder' => 'Code'
                ]
            ])
            ->add('user', EmailType::class, [
                'label' => 'Mail utilisé à l\'inscription*',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre mail'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Validation::class,
        ]);
    }
}
