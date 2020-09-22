<?php

namespace App\Form;

use App\Entity\Virement;
use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VirementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dtVirement')
            ->add('totalSalaire')
            ->add('reste')
            ->add('idProf')
            ->add('idPersonnel',EntityType::class, [
                'class'=>Personne::class,
                'label'=>'Matiere',
                'placeholder'=>' ',
                'choice_label'=>function($matiere){
                return $matiere->getPrenom().' '.$matiere->getNom();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Virement::class,
        ]);
    }
}
