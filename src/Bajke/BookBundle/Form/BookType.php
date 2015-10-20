<?php

namespace Bajke\BookBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add('owner', 'textarea', [
                'disabled' => ($options['is_edit'] || $options['is_owner_disabled'])
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'Bajke\BookBundle\Entity\Book',
            'is_edit' => false,
            'is_owner_disabled' => false,
        ]);
    }

    public function getName() {
        return "book";
    }
}