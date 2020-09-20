<?php

namespace App\Form;

use App\Entity\Affectation;
use App\Entity\Matiere;
use App\Repository\AffectationRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AffectationType extends AbstractType
{
    private $userRepository;
    public function __construct(AffectationRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('jour')
            ->add('paye' )
            ->add('reste')
            ->add('id_matiere',EntityType::class, [
                'class'=>Matiere::class,
                'label'=>'Nom de la matiere',
                'placeholder' => ''
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
                        'placeholder'=>""
                    ]);
                }
            }
        );
//
//        $builder->get('id_matiere')->addEventListener(
//            FormEvents::POST_SUBMIT,
//            function (FormEvent $event) {
//                $form= $event->getForm();
//                $form->getParent()->add('id_professeur', EntityType::class, [
//                    'class' => 'App\Entity\Professeur',
//                    'mapped'=>false,
//                    'query_builder'=>function (ProfesseurRepository $pr) use ($form) {
//                        return $pr->findByExampleField($form->getData());
//                    },
//                    'label'=>'Nom du professeur'
//                ]);
//            }
//        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Affectation::class,
            'id_matiere' => null,
        ]);
    }
}
