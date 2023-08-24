<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GameRepository;




class PropertySearchType extends AbstractType
{
    private $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $genresEntities = $this->gameRepository->findDistinctGenres();

        $genres = [];
        foreach ($genresEntities as $genreEntity) {
            $genres[] = $genreEntity['genres'];
        }

        $platformsEntities = $this->gameRepository->findDistinctPlatforms();


        $platforms = [];
        foreach ($platformsEntities as $platformEntity) {
            $platforms[] = $platformEntity['platform'];
        }

        $builder
            ->add('platform', ChoiceType::class, [
                'choices' => array_combine($platforms, $platforms),
                'required' => false,
                'placeholder' => 'Choose a platform',

            ])
            ->add('genres', ChoiceType::class, [
                'choices' => array_combine($genres, $genres),
                'required' => false,
                'placeholder' => 'Choose a genre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}
