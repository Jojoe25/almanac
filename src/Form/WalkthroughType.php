<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Walkthrough;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WalkthroughType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('dateCreated', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('overview')
            ->add('dateModified', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Walkthrough::class,
        ]);
    }
}
