<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('day', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'label' => 'Jour de la session',
            ])
            ->add('startTime', TimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'label' => 'Heure de début',
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée (en minutes)',
            ]);
    }
}
