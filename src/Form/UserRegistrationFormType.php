<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('plainPassword',RepeatedType::class, [
                'mapped'=>false,
                'type' => PasswordType::class,
                'invalid_message' => 'le mot de passe n est pas le meme',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'mot de passe'],
                'second_options' => ['label' => 'Confirmation du mot de passe'],
                'constraints'=>[
                    new NotBlank,
                    new Length(['min'=>6 , 'max'=>4096])
                ]
            ])
            ->add('roles',ChoiceType::class, [
                'mapped'=>false,
                'choices' => [
                    'Admin' => [
                        'ROLE_ADMIN' => "ROLE_ADMIN"
                    ],
                    'visiteur' => [
                        "ROLE_USER" => "ROLE_USER"
                    ]
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
