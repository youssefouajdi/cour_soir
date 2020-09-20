<?php

namespace App\Form;

use App\Entity\Eleve;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('niveau',ChoiceType::class, [
                    'choices' => [
                        'eleve' => [
                            'Yes' => 'stock_yes',
                            'No' => 'stock_no',
                        ],
                        'etudiant' => [
                            'Backordered' => 'stock_backordered',
                            'Discontinued' => 'stock_discontinued',
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
