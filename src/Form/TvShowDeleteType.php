<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Person;
use App\Entity\TvShow;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TvShowDeleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            "title",
            TextType::class,
            [
                "label" => "Titre de la série"
            ]
        );
        

        // https://symfony.com/doc/current/best_practices.html#add-form-buttons-in-templates
        /*
        $builder->add(
            "submit",
            SubmitType::class,
            [
                "label" => "Ajouter / modifier"
            ]
        );
        */
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TvShow::class,
        ]);
    }
}