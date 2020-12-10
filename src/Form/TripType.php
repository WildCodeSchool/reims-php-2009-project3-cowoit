<?php

namespace App\Form;

use App\Entity\Trip;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('addressStart')
            ->add('addressEnd')
            ->add('nbPassengers')
            ->add('driver', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
                'multiple' => false,
                'expanded' => false,
                'by_reference' => false,
            ])
            /* ->add('driver', ChoiceType::class, ['choice_value' => '1']) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
