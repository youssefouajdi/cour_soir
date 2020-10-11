<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Matiere;
use App\Entity\Niveau;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('email',EmailType::class)
            ->add('tel',NumberType::class)
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
            ->add('paye' ,null,[
                'mapped'=>false
            ])
            ->add('reste',null,[
                'mapped'=>false
            ])
            ->add('id_matiere',EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Nom de la matiere',
                'placeholder' => '',
                "mapped"=>false
            ])
            ->add('id_matiere2',EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Nom de la matiere',
                'placeholder' => '',
                'mapped'=>false,
                'required'=>false
            ])
            ->add('id_matiere3',EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Nom de la matiere',
                'placeholder' => '',
                "mapped"=>false,
                'required'=>false
            ])
            
        ;
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use($options) {
                $idMatiere  = (int)$options['id_matiere'];
                $form=$event->getForm();
                if($idMatiere !=null){
                    $form->add('id_professeur',EntityType::class,[
                        'mapped'=>false,
                        'class'=>'App\Entity\Professeur',
                        'placeholder'=>"",
                        'required'=>false,
                        'query_builder'=>function (EntityRepository $er) use ($form, $idMatiere) {
                        return $er->createQueryBuilder('p')
                            ->where('p.idMatiere = :val')
                            ->setParameter('val', $idMatiere);
                        },
                        'choice_label' =>'prenom'
                    ]);
                }else{
                    $form->add('id_professeur',EntityType::class,[
                        'mapped'=>false,
                        'class'=>'App\Entity\Professeur',
                        'placeholder'=>"",
                        'required'=>false
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
                    $form->add('id_professeur2',EntityType::class,[
                        'mapped'=>false,
                        'class'=>'App\Entity\Professeur',
                        'placeholder'=>"",
                        'required'=>false,
                        'query_builder'=>function (EntityRepository $er) use ($form, $idMatiere2) {
                        return $er->createQueryBuilder('p')
                            ->where('p.idMatiere = :val')
                            ->setParameter('val', $idMatiere2);
                        },
                        'choice_label' =>'prenom'
                    ]);
                }else{
                    $form->add('id_professeur2',EntityType::class,[
                        'mapped'=>false,
                        'class'=>'App\Entity\Professeur',
                        'placeholder'=>"",
                        'required'=>false
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
                    $form->add('id_professeur3',EntityType::class,[
                        'mapped'=>false,
                        'class'=>'App\Entity\Professeur',
                        'placeholder'=>"",
                        'required'=>false,
                        'query_builder'=>function (EntityRepository $er) use ($form, $idMatiere3) {
                        return $er->createQueryBuilder('p')
                            ->where('p.idMatiere = :val')
                            ->setParameter('val', $idMatiere3);
                        },
                        'choice_label' =>'prenom'
                    ]);
                }else{
                    $form->add('id_professeur3',EntityType::class,[
                        'mapped'=>false,
                        'class'=>'App\Entity\Professeur',
                        'placeholder'=>"",
                        'required'=>false
                    ]);
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
            'id_matiere' => null,
            'id_matiere2'=> null,
            'id_matiere3'=> null
        ]);
    }
}
