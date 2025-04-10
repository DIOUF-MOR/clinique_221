<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Entity\Secretaire;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateHeure', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'label' => 'Date et heure du rendez-vous',
                'attr' => [
                    'class' => 'form-control',
                    'min' => (new \DateTime())->format('Y-m-d\TH:i'),
                ],
            ])

            ->add('dateCreation', DateTimeType::class, [
                'attr' => [
                    'placeholder' => 'Date de création',
                    'class' => 'form-control',
                ],
                'widget' => 'single_text',
            ])
            ->add('statut', TextType::class, [
                'attr' => ['placeholder' => 'Statut'],
            ])
            ->add('secretaire', EntityType::class, [
                'class' => Secretaire::class,
                'choice_label' => 'prenom' . 'nom',
                'attr' => [
                    'placeholder' => 'Secretaire',
                    'class' => 'form-control',
                ],
            ])
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => 'prenom' . 'nom',
                'attr' => [
                    'placeholder' => 'Patient',
                    'class' => 'form-control',
                ],
            ])
            ->add('ajouter', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
