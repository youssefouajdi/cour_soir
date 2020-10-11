<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Niveau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class MatiereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomMatiere')
            ->add('niveau',EntityType::class, [
                'class'=>Niveau::class,
                'label'=>'Niveau',
                'required'=>true,
                'placeholder'=>'',
                'mapped'=>false,
                'choice_label'=>function($matiere){
                    return $matiere->getNomNiveau();
                }
            ])
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
