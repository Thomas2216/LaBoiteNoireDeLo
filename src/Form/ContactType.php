<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank(message: 'Merci d\'indiquer votre nom.'),
                    new Length(max: 255),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(message: 'Merci d\'indiquer votre email.'),
                    new Email(message: 'Cette adresse email n\'est pas valide.'),
                ],
            ])
            ->add('prestation', ChoiceType::class, [
                'label' => 'Type de prestation',
                'choices' => [
                    'Photographie de spectacle' => 'Photographie de spectacle',
                    'Photographie d\'evenement' => 'Photographie d\'evenement',
                    'Photographie associative' => 'Photographie associative',
                    'Autre demande' => 'Autre demande',
                ],
                'constraints' => [
                    new NotBlank(message: 'Merci de choisir un type de prestation.'),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'constraints' => [
                    new NotBlank(message: 'Merci de decrire votre projet.'),
                    new Length(min: 10, max: 5000),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'csrf_protection' => true,
        ]);
    }
}
