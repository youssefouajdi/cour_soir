<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Professeur;
use App\Entity\ProfesseurSearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfesseurSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomProf',EntityType::class, [
                'class'=>Professeur::class,
                'label'=>'Nom Professeur',
                'required'=>true,
                'choice_label'=>function($professeur){
                    return $professeur->getNom();
                }
            ])
            ->add('prenomProf',EntityType::class, [
                'class'=>Professeur::class,
                'label'=>'Prenom Professeur',
                'required'=>true,
                'choice_label'=>function($professeur){
                    return $professeur->getPrenom();
                }
            ])/*
            ->add('module',EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Matiere / Niveau',
                'required'=>false,
                'choice_label'=>function($matiere){
                    return $matiere->getNomMatiere().' '.
                        $matiere->getNiveau();
                }
            ])*/
            ->add('submit',SubmitType::class,[
                'label'=> 'Rechercher'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfesseurSearch::class,
            'method'=>'get',
            'csrf_protection'=>false
        ]);
    }
}
