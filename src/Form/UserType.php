<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => "L'email ne peut pas être vide."]),
                    new Assert\Email(['message' => "L'email '{{ value }}' n'est pas valide."])
                ],
                'attr' => ['class' => 'form-control'],
                'label' => 'Email',
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => "Le prénom ne peut pas être vide."]),
                    new Assert\Regex([
                        'pattern' => "/^[a-zA-ZÀ-ÿ]+$/",
                        'message' => "Le prénom ne peut contenir que des lettres."
                    ]),
                ],
                'attr' => ['class' => 'form-control'],
                'label' => 'Prénom',
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => "Le nom ne peut pas être vide."]),
                    new Assert\Regex([
                        'pattern' => "/^[a-zA-ZÀ-ÿ]+$/",
                        'message' => "Le nom ne peut contenir que des lettres."
                    ]),
                ],
                'attr' => ['class' => 'form-control'],
                'label' => 'Nom',
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Gestionnaire' => 'ROLE_MANAGER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'expanded' => true,
                'multiple' => true, 
                'label' => 'Rôles',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
