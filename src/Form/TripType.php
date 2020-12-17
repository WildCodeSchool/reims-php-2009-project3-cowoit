<?php

namespace App\Form;

use App\Entity\Trip;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'choice',
                'label' => 'Jour-Mois-Année',
                'format' => 'dd-MM-yyyy',
                'input' => 'string',
            ])
            ->add('addressStart', TextType::class, [
                'label' => 'Départ',
            ])
            ->add('addressEnd', TextType::class, [
                'label' => 'Arrivée',
            ])
            ->add('nbPassengers', IntegerType::class, [
                'label' => 'Nombre de Passagers',
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
