<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'label' => 'Email',
                'attr' => array(
                    'placeholder' => 'Email',
                    'class' => 'form-control',
                )
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'label' => 'Accepter les conditions',
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'label' => 'Mot De Passe',
                'attr' => array(
                    'placeholder' => 'Mot De Passe',
                    'class' => 'form-control',
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'label' => 'Prénom',
                'attr' => array(
                    'placeholder' => 'Prénom',
                    'class' => 'form-control',
                )
            ])
            ->add('lastname', TextType::class, [
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'label' => 'Nom',
                'attr' => array(
                    'placeholder' => 'Nom',
                    'class' => 'form-control',
                )
            ])
            ->add('photoFile', VichFileType::class, [
                'required'      => false,
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'label' => 'Photo de Profile',
                'attr' => array(
                    'placeholder' => 'Photo de Profile',
                    'class' => 'form-control',
                )
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
