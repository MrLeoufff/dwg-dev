<?php

namespace App\Form;

use App\Entity\Product;
use App\Form\SessionType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function __construct(private Security $security)
    {}
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('type', ChoiceType::class, [
                'choices' => ['Site web' => 'site_web', 'Formation' => 'formation'],
                'label' => 'Type de service',
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début de formation',
            ])
            ->add('sessions', CollectionType::class, [
                'entry_type' => SessionType::class,
                'entry_options' => ['attr' => ['class' => 'session-item']],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Sessions de formation',
                'prototype' => true,
                'prototype_name' => '__name__',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
