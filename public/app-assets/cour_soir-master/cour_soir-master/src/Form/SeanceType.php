<?php

namespace App\Form;

use App\Entity\Seance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dtdebut', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
            ->add('dtfin', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
            ->add('jourdelasemaine',  ChoiceType::class, array(
                'mapped'=>false,
                'choices' => array(
                    'dimanche'=>'Sunday',
                    'lundi'=>'Monday',
                    'mardi'=>'Tuesday',
                    'mercredi'=>'Wednesday' ,
                    'jeudi'=>'Thursday',
                    'vendredi'=>'Friday',
                    'samedi'=>'Saturday'
                    ),
                 'multiple' => true, 'expanded' => true
            ))
            ->add('hDebut')
            ->add('hFin')
            ->add('salle')
            ->add('effectuer')
            ->add('idMatiere')
            ->add('idProfesseur')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
        ]);
    }
}
