<?php

namespace App\Form;

use App\Entity\Trip;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CreateTripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'years' => range(date('Y'), date('Y') + 3),
                'input' => 'string',
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Date',
                    'class' => 'form-control',
                )
            ])
            ->add('addressStart', TextType::class, [
                'label' => 'Départ',
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Départ',
                    'class' => 'form-control',
                )
            ])
            ->add('addressEnd', TextType::class, [
                'label' => 'Arrivée',
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Arrivée',
                    'class' => 'form-control',
                )
            ])
            ->add('nbPassengers', IntegerType::class, [
                'label' => 'Nombre de Passagers',
                'label_attr' => array(
                    'class' => 'form-label',
                ),
                'attr' => array(
                    'placeholder' => 'Nombre de Passagers',
                    'class' => 'form-control',
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
