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
                    ],
                    'etudiant' => [
                        'Backordered' => 'stock_backordered',
                        'Discontinued' => 'stock_discontinued',
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
