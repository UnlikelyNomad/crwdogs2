<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('email', EmailType::class, [
                'help' => "Used to log in. We'll email you a random password for your first login."
            ])
            ->add('nick', TextType::class, [
                'help' => "The name we display for you in the forms and throughout the site."
            ])
            ->add('first_name', TextType::class, [
                'help' => "Your real name will only be visible to organizers of events you register for."
            ])
            ->add('last_name', TextType::class)
            ->add('phone', TextType::class, [
                'help' => "Provided to organizers of events you register for if they need to contact you before or during an event, otherwise not shared."
            ])
            ->add('location', TextType::class, [
                'help' => "Displayed on your profile to give people an idea of where you jump."
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
