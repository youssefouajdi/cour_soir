<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Professeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfesseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('tel')
            ->add('idMatiere',EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Matiere /Niveau',
                'choice_label'=>function($matiere){
                return $matiere->getNomMatiere().' '.
                    $matiere->getNiveau();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Professeur::class,
        ]);
    }
}
