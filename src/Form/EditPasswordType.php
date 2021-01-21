<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'The password fields must match.',
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options'  => [
                'label' => 'Mot de Passe',
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Mot de Passe',
                    'class' => 'form-control',
                ),
            ],
            'second_options' => [
                'label' => 'Répéter le Mot de Passe',
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Répéter le Mot de Passe',
                    'class' => 'form-control',
                ),
            ],
            'constraints' => [
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
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
