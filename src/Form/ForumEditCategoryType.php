<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\ForumCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ForumEditCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, [
            ])
            ->add('description', CKEditorType::class, [
                'config' => [
                ]
            ])
            ->add('sort', IntegerType::class, [
                'help' => 'Lower numbers show up earlier in the category listing.',
            ])
            ->add('locked', CheckboxType::class, [
                'help' => 'Locked categories only allow ROLE_ADMIN to create topics.',
                'required' => false,
            ])
            ->add('roles_read', ChoiceType::class, [
                'expanded' => true,
                'multiple' => true,
                'choices' => $options['role_names'],
                'choice_label' => function($choice, $key, $value) {
                        return $value;
                    },
                'help' => 'Select none for everyone to be able to read this forum.',
            ])
            ->add('roles_create', ChoiceType::class, [
                'expanded' => true,
                'multiple' => true,
                'choices' => $options['role_names'],
                'choice_label' => function($choice, $key, $value) {
                        return $value;
                    },
                'help' => 'Only users with the assigned roles will be able to create new topics.',
            ])
            ->add('roles_mod', ChoiceType::class, [
                'expanded' => true,
                'multiple' => true,
                'choices' => $options['role_names'],
                'choice_label' => function($choice, $key, $value) {
                        return $value;
                    },
                'help' => 'Selected Roles will be able to edit and delete other user\'s posts.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $roles = ['ROLE_USER', 'ROLE_ADMIN'];

        $resolver->setDefaults([
            'data_class' => ForumCategory::class,
            'role_names' => $roles,
        ]);
    }
}