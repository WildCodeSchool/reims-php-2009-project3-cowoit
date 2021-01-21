<?php

namespace App\Form;

use App\Entity\Participation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', ChoiceType::class, [
                'placeholder' => 'Noter votre trajet',
                'choices' => [
                    'Parfait' => 5,
                    'Très bien' => 4,
                    'Bien' => 3,
                    'Décevant' => 2,
                    'À éviter' => 1,
                ],
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Note',
                    'class' => 'form-control',
                )
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Commentaire',
                    'class' => 'form-control',
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participation::class,
        ]);
    }
}
