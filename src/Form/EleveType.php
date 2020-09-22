<?php

namespace App\Form;

use App\Entity\Eleve;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('transport')
            ->add('dtInscription')
            ->add('email',EmailType::class)
            ->add('tel',NumberType::class)
            ->add('niveau',ChoiceType::class,[
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
                ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
