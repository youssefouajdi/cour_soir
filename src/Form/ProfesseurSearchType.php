<?php

namespace App\Form;
use Doctrine\ORM\EntityRepository;
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
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ProfesseurSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('module',EntityType::class, [
            'class'=>Matiere::class,
            'label'=>'Nom de la matiere',
            'placeholder' => '',
                'row_attr' => [
                    'class' => 'myclass'
                ],
            'choice_label'=>function($matiere){
                return $matiere->getNiveau().' '. $matiere->getNomMatiere();
                }
        ])
    ;
       
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($options) {
                $module  = (int)$options['module'];
                $form=$event->getForm();
                if($module != null){
                    $form->add('id_professeur',EntityType::class,[
                        'mapped'=>false,
                        'class'=>'App\Entity\Professeur',
                        'placeholder'=>"",
                        'label'=>'Le professeur',
                        'query_builder'=>function (EntityRepository $er) use ($form, $module) {
                        return $er->createQueryBuilder('p')
                            ->where('p.idMatiere= :val')
                            ->setParameter('val', $module);
                        },
                        'choice_label' =>function($matiere){
                            return $matiere->getNom().' '. $matiere->getPrenom();
                            }
                    ]
                );
                }else{
                    $form->add('id_professeur',EntityType::class,[
                        'mapped'=>false,
                        'class'=>'App\Entity\Professeur',
                        'label'=>'Le professeur',
                        'placeholder'=>""
                    ]);
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfesseurSearch::class,
            'module' => null,
            'method'=>'get',
            'csrf_protection'=>false
        ]);
    }
}
