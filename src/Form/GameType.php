<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //todo ajouter developpeur,
            // gerrer l'upload des images back & posters.
            // gerrer les choix multiples pour platform et genres.

            ->add('name', TextType::class, [
                'label' => 'Title'
            ])
            ->add('overview',null, [
                'required' => false,
            ])

            ->add('vote')
            ->add('platform', ChoiceType::class, [
                'choices' => [
                    'NES' => 'NES',
                    'SNES' => 'SNES',
                    'PC' => 'PC',
                    'PS1' => 'PS1',
                    'PS2' => 'PS2',
                    'PS3' => 'PS3',
                    'PS4' => 'PS4',
                    'PS5' => 'PS5',
                    'Sega Saturn' => 'Sega Saturn',
                    'Mega Drive' => 'Mega Drive',
                    'Master System' => 'Master System',
                    'Game Gear'=> 'Game Gear',
                    'GameBoy' => 'GameBoy',
                    'Nintendo Switch' => 'Nintendo Switch',
                    'Xbox' => 'Xbox',
                    'Xbox 360' => 'Xbox 360',
                    'Xbox One' => 'Xbox One',
                    'Xbox Series X/S' => 'Xbox Series X/S',
                    'Nintendo 64' => 'Nintendo 64',
                    'GameCube' => 'GameCube',
                    'Wii' => 'Wii',
                    'Wii U' => 'Wii U',
                    'Nintendo 3DS' => 'Nintendo 3DS',
                    'PlayStation Portable (PSP)' => 'PlayStation Portable (PSP)',
                    'PlayStation Vita' => 'PlayStation Vita',
                    'Atari 2600' => 'Atari 2600',
                    'Sega Genesis' => 'Sega Genesis',
                    'Dreamcast' => 'Dreamcast',
                    'Game Boy Advance' => 'Game Boy Advance',
                    'PlayStation 5 Digital Edition' => 'PlayStation 5 Digital Edition',
                    'Xbox Series S' => 'Xbox Series S',
                    'Nintendo DS' => 'Nintendo DS',
                    'Nintendo Wii Mini' => 'Nintendo Wii Mini',
                    'PlayStation 4 Pro' => 'PlayStation 4 Pro',
                    'PlayStation Classic' => 'PlayStation Classic',
                    'Xbox One S' => 'Xbox One S',
                    'Xbox One X' => 'Xbox One X',
                    'Nintendo Entertainment System: NES Classic Edition' => 'Nintendo Entertainment System: NES Classic Edition',
                    'Super Nintendo Entertainment System: SNES Classic Edition' => 'Super Nintendo Entertainment System: SNES Classic Edition',
                ],
                'multiple' => false, //multiple true permet a l'utilisateur de choisir plusieurs consoles.
            ])
            ->add('genres', ChoiceType::class, [
                'choices' => [
                    'Plateforme' => 'Plateforme',
                    'RPG' => 'RPG',
                    'Action' => 'Action',
                    'Course' => 'Course',
                    'Aventure' => 'Aventure',
                    'FPS' => 'FPS',
                    'Sport' => 'Sport',
                    'Simulation' => 'Simulation',
                    'Stratégie' => 'Stratégie',
                    'Horreur' => 'Horreur',
                    'Combat' => 'Combat',
                    'Musique' => 'Musique',
                    'Party' => 'Party',
                    'Puzzle' => 'Puzzle',
                    'Survie' => 'Survie',
                    'Visual Novel' => 'Visual Novel',
                    'Jeu de rôle tactique' => 'Jeu de rôle tactique',
                    'Hack and Slash' => 'Hack and Slash',
                    'Art de rythme' => 'Art de rythme',
                    'Jeu de cartes' => 'Jeu de cartes',
                    'Jeu de société' => 'Jeu de société',
                    'Gestion' => 'Gestion',
                    'Point-and-Click' => 'Point-and-Click',
                    'Battle Royale' => 'Battle Royale',
                    'Tower Defense' => 'Tower Defense',
                    'Jeu d evasion' => 'Jeu d evasion',
                    'Jeu d action-aventure' => 'Jeu d action-aventure',
                    'Jeu de rôle en ligne massivement multijoueur (MMORPG)' => 'Jeu de rôle en ligne massivement multijoueur (MMORPG)',
                    'Jeu de danse' => 'Jeu de danse',
                    'Jeu de puzzle-aventure' => 'Jeu de puzzle-aventure',
                    'Jeu de survie en monde ouvert' => 'Jeu de survie en monde ouvert',
                ],
                'multiple' => false, //multiple true permet a l'utilisateur de choisir plusieurs consoles.
            ])
            ->add('publicationDate', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('backdrop', FileType::class, [
                'label' => 'Backdrop Image',
                'required' => false,
                'mapped' => false, // Indiquez que ce champ n'est pas lié directement à une propriété de l'entité
            ])
            ->add('poster', FileType::class, [
                'label' => 'Poster Image',
                'required' => false,
                'mapped' => false, // Indiquez que ce champ n'est pas lié directement à une propriété de l'entité
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}