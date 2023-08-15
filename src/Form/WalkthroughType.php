<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Walkthrough;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WalkthroughType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('dateCreated')
            ->add('overview')
            ->add('dateModified')
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
