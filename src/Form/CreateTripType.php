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
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y') + 3),
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
