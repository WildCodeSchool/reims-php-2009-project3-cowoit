<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Email',
                    'class' => 'form-control',
                )
            ])
            ->add('firstname', TextType::class, [
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Prénom',
                    'class' => 'form-control',
                )
            ])
            ->add('lastname', TextType::class, [
                'label_attr' => array(
                    'class' => 'form-label',
                ),
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
                'allow_delete' => false,
                'download_uri' => false,
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
