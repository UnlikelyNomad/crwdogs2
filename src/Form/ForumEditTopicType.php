<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\ForumTopic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ForumEditTopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('subject', TextType::class, [
            ])
            ->add('message', CKEditorType::class, [
            ])
            ->add('closed', CheckboxType::class, [
                'help' => 'Locked topics can only be posted to by topic mods.',
                'required' => false,
            ])
            ->add('sticky', CheckboxType::class, [
                'help' => 'Stickied topics show up at the top of the list.',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ForumTopic::class,
        ]);
    }
}