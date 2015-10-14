<?php

namespace Bajke\BookBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text')
            ->add('description', 'textarea');
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'Bajke\BookBundle\Entity\Book',
        ]);
    }

    public function getName() {
        return "book";
    }
}