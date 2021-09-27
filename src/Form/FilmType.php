<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Category;
use App\Entity\Film;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('releaseAt')
            ->add('category')
            ->add('artists', EntityType::class, [
                // looks for choices from this entity
                'class' => Artist::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'lastname',

                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }

    /**
     * toString
     * @return string
     */
    public function __toString() {
        return $this->getCategory();
    }
}
