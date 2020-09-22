<?php

namespace App\Form;
use Doctrine\ORM\EntityRepository;
use App\Entity\Matiere;
use App\Entity\Professeur;
use App\Entity\Absence;
use App\Entity\Seance;
use App\Entity\Eleve;
use App\Repository\MatiereRepository;
use App\Repository\EleveRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\Date;




class NewAbsenceType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
            'input' => 'datetime',
            'widget' => 'single_text',
            'data' => new \DateTime(),
            "mapped"=>false
            ])
             ->add('niveau' ,EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Niveau ',
                'placeholder'=>'',
                'choice_label'=>function($matiere){
                return $matiere->getNiveau();
                }
            ])

            ->add('salle',EntityType::class, [
                'class'=>Seance::class,
                'label'=>'Salle',
                'choice_label'=>function($salle){
                return $salle->getSalle();
                },
                    'mapped' => false,

            ])
            ->add('totalpresent', IntegerType::class,[
            'label' => 'Total présent',
            'disabled' => true,
            'attr' => ['value' => '32'],
            'mapped' => false,
        ])
            ->add('totalabsent', IntegerType::class,[
            'label' => 'Total absent',
            'disabled' => true,
            'mapped' => false,


        ])
          
           ->add('add',SubmitType::class,[
                'label' => 'Afficher les eleves',
            ])  
            ;
            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use($options) {
                    $idNiveau  = (int)$options['id_niveau'];
                    $form=$event->getForm();
                    if($idNiveau !=null){
                        $form->add('id_matiere',EntityType::class,[
                            'mapped'=>false,                            
                            'class'=>'App\Entity\Matiere',
                            'placeholder'=>"",
                            'query_builder'=>function (EntityRepository $er) use ($form, $idNiveau) {
                            return $er->createQueryBuilder('p')
                                ->where('p.niveau = :val')
                                ->setParameter('val', $idNiveau);
                            },
                            'choice_label' =>function($salle){
                                return $salle->getNomMatiere();
                                }
                        ]);
                    }else{
                        $form->add('id_matiere',EntityType::class,[
                            'mapped'=>false,
                            'class'=>'App\Entity\Matiere',
                            'placeholder'=>"",
                            'required'=>false,
                            'choice_label'=>function($salle){
                                return $salle->getNomMatiere();
                                }
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
                            'choice_label' =>function($salle){
                                return $salle->getPreNom();
                                }
                        ]);
                    }else{
                        $form->add('id_professeur',EntityType::class,[
                            'mapped'=>false,
                            'class'=>'App\Entity\Professeur',
                            'placeholder'=>"",
                            'required'=>false,
                            'choice_label'=>function($salle){
                                return $salle->getNom();
                                }
                        ]);
                    }
                }
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
            'id_niveau' => null,
            'id_matiere'=> null
        ]);
    }
}