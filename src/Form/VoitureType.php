<?php

namespace App\Form;

use App\Entity\Personne;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque')
            ->add('modele')
            ->add('immatriculation')
            ->add('annee', IntegerType::class, [
                'required' => false,
            ])
            ->add('proprietaire', EntityType::class, [
                'class' => Personne::class,
                'choice_label' => fn (Personne $p) => $p->getNom().' '.$p->getPrenom(),
                'placeholder' => 'Choisir un propriétaire',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
