<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('creator', EntityType::class, array(
//                'class' => 'App\Entity\User',
//                'attr' => [
//                    'readonly' => true
//                ]
//            ))
            ->add('title',TextType::class,  array('attr' =>['placeholder'=>'Title']))
            ->add('content',TextareaType::class,  array('attr' =>['placeholder'=>'Your Content']))
        ;

        $builder
            ->add('submit', SubmitType::class,
                ['label' => 'Send Post'])
        ;

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Post'
        ));
    }
}