<?php

namespace App\Form;

use App\Entity\Paiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Matiere;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\Eleve;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dtPaiement',DateType::class, [
                'label'=>'Date de Paiement',
                
            ])
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
                'placeholder'=>'',
                'mapped'=>false,
                'choice_label'=>function($matiere){
                    return $matiere->getNiveau().' '.$matiere->getNomMatiere();
                }
            ])
           /* ->add('PrixMatiere',NumberType::class, [
                'required'=>true,
                'label'=>'Prix de la matiere',
                'query_builder'=>function (EntityRepository $er) use ($idMatiere) {
                    return $er->createQueryBuilder('p')
                        ->where('p.idMatiere = :val')
                        ->setParameter('val', $idMatiere);
                    },
                'mapped'=>false
            ])*/
            ->add('PrixPaye',NumberType::class, [
                'label'=>'Prix payer de la matiere',
                'mapped'=>false
            ])
            ->add('idMatiere1',EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Matiere',
                'placeholder'=>'',
                'mapped'=>false,
                'choice_label'=>function($matiere){
                    return $matiere->getNiveau().' '.$matiere->getNomMatiere();
                }
            ])
           
            ->add('PrixPaye1',NumberType::class, [
                'label'=>'Prix payer de la matiere',
                'mapped'=>false
            ])
            ->add('idMatiere2',EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Matiere',
                'placeholder'=>'',
                'mapped'=>false,
                'choice_label'=>function($matiere){
                    return $matiere->getNiveau().' '.$matiere->getNomMatiere();
                }
            ])
         
            ->add('PrixPaye2',NumberType::class, [
                'label'=>'Prix payer de la matiere',
                'mapped'=>false
            ])
            ->add('montantTotal')
            ->add('motantRest')
        ;
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use($options) {
                $idMatiere  = (int)$options['id_matiere'];
                $form=$event->getForm();
                if($idMatiere !=null){
                    $form->add('PrixMatiere',EntityType::class, [
                        'mapped'=>false,
                        'class'=>'App\Entity\Matiere',
                        'required'=>true,
                        'query_builder'=>function (EntityRepository $er) use ($form,$idMatiere) {
                            return $er->createQueryBuilder('p')
                                ->where('p.idMatiere = :val')
                                ->setParameter('val', $idMatiere);
                            },
                            'choice_label' =>'prix'
                    ]);
                }else{
                    $form->add('PrixMatiere',NumberType::class, [
                        'required'=>true,
                        'label'=>'Prix de la matiere',
                        'data'=>0,
                        'mapped'=>false
                    ]);
                }
            }
        );
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use($options) {
                $idMatiere2  = (int)$options['id_matiere2'];
                $form=$event->getForm();
                if($idMatiere2 !=null){
                    $form->add('PrixMatiere1',EntityType::class, [
                        'mapped'=>false,
                        'class'=>'App\Entity\Matiere',
                        'required'=>true,
                        'query_builder'=>function (EntityRepository $er) use ($form,$idMatiere2) {
                            return $er->createQueryBuilder('p')
                                ->where('p.idMatiere = :val')
                                ->setParameter('val', $idMatiere2);
                            },
                            'choice_label' =>'prix'
                    ]);
                }else{
                    $form->add('PrixMatiere1',NumberType::class, [
                        'required'=>true,
                        'label'=>'Prix de la matiere',
                        'data'=>0,
                        'mapped'=>false
                    ]);
                }
            }
        );
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use($options) {
                $idMatiere3  = (int)$options['id_matiere3'];
                $form=$event->getForm();
                if($idMatiere3 !=null){
                    $form->add('PrixMatiere2',EntityType::class, [
                        'mapped'=>false,
                        'class'=>'App\Entity\Matiere',
                        'required'=>true,
                        'query_builder'=>function (EntityRepository $er) use ($form,$idMatiere3) {
                            return $er->createQueryBuilder('p')
                                ->where('p.idMatiere = :val')
                                ->setParameter('val', $idMatiere3);
                            },
                            'choice_label' =>'prix'
                    ]);
                }else{
                    $form->add('PrixMatiere2',NumberType::class, [
                        'required'=>true,
                        'label'=>'Prix de la matiere',
                        'data'=>0,
                        'mapped'=>false
                    ]);
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
            'id_matiere' => null,
            'id_matiere2'=> null,
            'id_matiere3'=> null
        ]);
    }
}
