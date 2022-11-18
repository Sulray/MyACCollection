<?php

namespace App\Form;

use App\Entity\Gallery;
use App\Repository\CardRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);
        $gallery = $options['data'] ?? null;
        $member = $gallery->getMember();

        $builder
            ->add('description')
            ->add('published')
            ->add('cards')
            ->add('member', null, [
                'disabled'   => true,
            ])
            ->add('cards', null, [
                'query_builder' => function (CardRepository $er) use ($member) {
                        return $er->createQueryBuilder('g')
                            ->leftJoin('g.village', 'i')
                            ->andWhere('i.member = :member')
                            ->setParameter('member', $member)
                            ;
                    }
                ])
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
