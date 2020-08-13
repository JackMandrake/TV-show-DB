<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\TvShow;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            "name",
            TextType::class,
            [
                "label" => "Nom du personnage"
            ]
        );
    
        $builder->add(
            "tvShow",
            EntityType::class,
            [
            "class" => TvShow::class,
            "choice_label" => "title",
            "multiple" => false,
            "expanded" => true
        ]
        );
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}