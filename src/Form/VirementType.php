<?php

namespace App\Form;

use App\Entity\Virement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VirementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dtVirement')
            ->add('totalSalaire')
            ->add('reste')
            ->add('idProf')
            ->add('idPersonnel')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Virement::class,
        ]);
    }
}
