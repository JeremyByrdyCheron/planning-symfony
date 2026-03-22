<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Matière: '])
            ->add('teacher', TextType::class, ['label' => 'Professeur: '])
            ->add('room', TextType::class, ['label' => 'Salle: '])
            ->add('level', TextType::class, ['label' => 'Niveau: '])
            ->add('date', DateType::class, [
                'label' => 'Date : ',
                'data' => new \DateTime()
            ])
            ->add('start', TimeType::class, ['label' => 'Début: '])
            ->add('end', TimeType::class, ['label' => 'Fin: '])
            ->add('save', SubmitType::class, ['label' => 'Confirmer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
