<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email',
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Email',
                    'class' => 'form-control',
                )
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Prénom',
                    'class' => 'form-control',
                )
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Nom',
                    'class' => 'form-control',
                )
            ])
            ->add('phone', NumberType::class, [
                'label' => 'Numéro de Téléphone',
                'required'   => false,
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Numéro de Téléphone',
                    'class' => 'form-control',
                )
            ])
            ->add('bio', TextareaType::class, [
                'label' => 'A propos de vous',
                'required'   => false,
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'MiniBio',
                    'class' => 'form-control',
                )
            ])
            ->add('vehicle', TextType::class, [
                'label' => 'Votre Véhicule',
                'required'   => false,
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Votre Véhicule',
                    'class' => 'form-control',
                )
            ])
            ->add('photoFile', VichFileType::class, [
                'required'      => false,
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'allow_delete' => false,
                'download_uri' => false,
                'label' => 'Photo de Profil',
                'attr' => array(
                    'placeholder' => 'Photo de Profil',
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
