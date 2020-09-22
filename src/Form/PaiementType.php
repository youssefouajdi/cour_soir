<?php

namespace App\Form;

use App\Entity\Paiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Matiere;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\Eleve;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dtPaiement')
            ->add('mode',ChoiceType::class,[
                'choices' => [
                    'cheque' => 'cheque',
                        'cash' => 'cash'
                ]])
           
            ->add('idEleve',EntityType::class, [
                'class'=>Eleve::class,
                'label'=>'eleve',
                'required'=>true,
                'placeholder'=>'',
                'mapped'=>false,
                'choice_label'=>function($matiere){
                    return $matiere->getNom().' '.$matiere->getPrenom();
                }
            ])
            ->add('idMatiere',EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Matiere',
                'required'=>true,
                'placeholder'=>'',
                'mapped'=>false,
                'choice_label'=>function($matiere){
                    return $matiere->getNiveau().' '.$matiere->getNomMatiere();
                }
            ])
            ->add('PrixMatiere',NumberType::class, [
                'required'=>true,
                'label'=>'Prix de la matiere',
                'data'=>250,
                'mapped'=>false
            ])
            ->add('PrixPaye',NumberType::class, [
                'required'=>true,
                'label'=>'Prix payer de la matiere',
                'mapped'=>false
            ])
            ->add('idMatiere1',EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Matiere',
                'required'=>true,
                'placeholder'=>'',
                'mapped'=>false,
                'choice_label'=>function($matiere){
                    return $matiere->getNiveau().' '.$matiere->getNomMatiere();
                }
            ])
            ->add('PrixMatiere1',NumberType::class, [
                'required'=>true,
                'label'=>'Prix de la matiere',
                'data'=>250,
                'mapped'=>false
            ])
            ->add('PrixPaye1',NumberType::class, [
                'required'=>true,
                'label'=>'Prix payer de la matiere',
                'mapped'=>false
            ])
            ->add('idMatiere2',EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Matiere',
                'required'=>true,
                'placeholder'=>'',
                'mapped'=>false,
                'choice_label'=>function($matiere){
                    return $matiere->getNiveau().' '.$matiere->getNomMatiere();
                }
            ])
            ->add('PrixMatiere2',NumberType::class, [
                'required'=>true,
                'label'=>'Prix de la matiere',
                'data'=>250,
                'mapped'=>false
            ])
            ->add('PrixPaye2',NumberType::class, [
                'required'=>true,
                'label'=>'Prix payer de la matiere',
                'mapped'=>false
            ])
            ->add('montantTotal')
            ->add('motantRest')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
