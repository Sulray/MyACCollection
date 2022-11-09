<?php

namespace App\Form;

use App\Entity\Gallery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('published')
            ->add('cards')
            ->add('member')
        ;
        if(! $options['task_is_new'] )
        {
            $builder
                ->add('description'); #ici non utilisé, ne rajoute rien
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gallery::class,
            'task_is_new' => false,
        ]);
        $resolver->setAllowedTypes('task_is_new', 'bool');
    }
}
