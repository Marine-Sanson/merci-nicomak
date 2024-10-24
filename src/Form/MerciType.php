<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Merci;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MerciType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reason', TextType::class, [
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'label' => 'Quelle est la raison de votre remerciement ?',
                'constraints' => [
                    new NotBlank(
                        [
                            'message' => 'Merci d\'indiquer une raison à votre remerciement',
                        ]
                    ),
                    new Length(
                        [
                            'min' => 5,
                            'minMessage' => 'La raison doit faire au moins {{ limit }} caractères',
                            'max' => 255,
                            'maxMessage' => 'La raison doit faire maximun {{ limit }} caractères',
                        ]
                    ),
                ]
            ])
            ->add('recipient', EntityType::class, [
                'class' => User::class,
                'label' => 'Choisissez la personne à remercier :',
                'choice_label' => 'username',
                'attr' => [
                    'class' => 'form-control my-3'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Merci::class,
        ]);
    }
}
