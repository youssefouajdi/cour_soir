<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Professeur;
use App\Entity\Absence;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matiere', EntityType::class, [
                'class' => Matiere::class ,
                'label' => 'Matiere',
                'required' => true,
                'choice_label' => function($matiere){
                    return $matiere->getNomMatiere();
                }
            ]) 
             ->add('professeur',EntityType::class, [
                'class'=>Professeur::class,
                'label'=>'Nom Professeur',
                'required'=>true,
                'choice_label'=>function($professeur){
                    return $professeur->getNom();
                }
            ])
             ->add('niveau',EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Niveau',
                'required'=>true,
                'choice_label'=>function($matiere){
                    return $matiere->getNiveau();
                }
            ])  
            ->add('submit',SubmitType::class,[
                'label' => 'Rechercher' 
            ])  
            ->add('add',SubmitType::class,[
                'label' => 'Ajouter Absence',
                 
            ]) 
             
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}