<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Professeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProfesseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    
        $builder
            ->add('nom')
            ->add('id_user')
            ->add('prenom')
            ->add('tel')
            ->add('idMatiere',ChoiceType::class, [
                'placeholder'=>"",
                'choices' => [
                        'Math' => 'Math',
                        'Physique' => 'Physique',
                        'SVT' => 'SVT',
                        'Francais'=>'Francais'
                ]]);
            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use($options) {
                    $idMatiere  = (int)$options['id_matiere'];
                    $form=$event->getForm();
                    if($idMatiere !=null){
                        dd($idMatiere);
                        $form->add('id_professeur',EntityType::class,[
                            'mapped'=>false,
                            'class'=>'App\Entity\Matiere',
                            'placeholder'=>"",
                            'label'=>'niveau',
                            'required'=>false,
                            'query_builder'=>function (EntityRepository $er) use ($form, $idMatiere) {
                            return $er->createQueryBuilder('p')
                                ->where('p.nomMatiere = :val')
                                ->setParameter('val', $idMatiere);
                            },
                            'choice_label' =>'niveau'
                        ]);
                    }else{
                        $form->add('id_professeur',EntityType::class,[
                            'mapped'=>false,
                            'class'=>'App\Entity\Matiere',
                            'placeholder'=>"",
                            'label'=>'niveau',
                            'required'=>false
                        ]);
                    }
                }
            );
            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use($options) {
                    $idMatiere  = (int)$options['id_matiere'];
                    $form=$event->getForm();
                    if($idMatiere !=null){
                        $form->add('id_professeur2',EntityType::class,[
                            'mapped'=>false,
                            'class'=>'App\Entity\Matiere',
                            'placeholder'=>"",
                            'label'=>'niveau',
                            'required'=>false,
                            'query_builder'=>function (EntityRepository $er) use ($form, $idMatiere) {
                            return $er->createQueryBuilder('p')
                                ->where('p.nomMatiere = :val')
                                ->setParameter('val', $idMatiere);
                            },
                            'choice_label' =>'niveau'
                        ]);
                    }else{
                        $form->add('id_professeur2',EntityType::class,[
                            'mapped'=>false,
                            'class'=>'App\Entity\Matiere',
                            'placeholder'=>"",
                            'label'=>'niveau',
                            'required'=>false
                        ]);
                    }
                }
            );
            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use($options) {
                    $idMatiere  = (int)$options['id_matiere'];
                    $form=$event->getForm();
                    if($idMatiere !=null){
                        $form->add('id_professeur3',EntityType::class,[
                            'mapped'=>false,
                            'class'=>'App\Entity\Matiere',
                            'placeholder'=>"",
                            'label'=>'niveau',
                            'required'=>false,
                            'query_builder'=>function (EntityRepository $er) use ($form, $idMatiere) {
                            return $er->createQueryBuilder('p')
                                ->where('p.nomMatiere = :val')
                                ->setParameter('val', $idMatiere);
                            },
                            'choice_label' =>'niveau'
                        ]);
                    }else{
                        $form->add('id_professeur3',EntityType::class,[
                            'mapped'=>false,
                            'class'=>'App\Entity\Matiere',
                            'label'=>'niveau',
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
            'data_class' => Professeur::class,
            'id_matiere' => null
        ]);
    }
}
