<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre',
            ])
            ->add('information', null, [
                'label' => 'Informations de cuisson, puissance, nombre de personnes',
            ])
            ->add('ingredient', null, [
                'label' => 'Ingrédients',
            ])
            ->add('content', null, [
                'label' => 'Recette',
            ])
            ->add('image', FileType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
