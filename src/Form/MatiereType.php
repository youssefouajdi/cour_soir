<?php

namespace App\Form;

use App\Entity\Matiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatiereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomMatiere')
            ->add('niveau',ChoiceType::class, [
                'choices' => [
                    'eleve' => [
                        '1 AC' => '1 AC',
                        '2 AC' => '2 AC',
                        '3 AC' => '3 AC',
                        '1 BAC S'=>'1 BAC S',
                        '1 BAC SM'=>'1 BAC SM',
                        '2 BAC PC'=>'2 BAC PC',
                        '2 BAC SVT'=>'2 BAC SVT',
                        '2 BAC SM'=>'2 BAC SM'
                    ],
                    'etudiant' => [
                        'S1' => 'S1',
                        'S2' => 'S2',
                        'S3' => 'S3',
                        'S4' => 'S4',
                        'S5' => 'S5',
                        'S6' => 'S6'

                    ]
                ]])
            ->add('prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Matiere::class,
        ]);
    }
}
