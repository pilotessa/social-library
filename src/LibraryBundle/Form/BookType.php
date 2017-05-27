<?php

namespace LibraryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class BookType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('authors', EntityType::class, array(
                'class' => 'LibraryBundle:Author',
                'choice_label' => function ($author) {
                    return $author->getFirstName() . ' ' . $author->getLastName();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->addOrderBy('a.firstName', 'ASC')
                        ->addOrderBy('a.lastName', 'ASC');
                },
                'multiple' => true,
                'expanded' => true
            ))
            ->add('genres', EntityType::class, array(
                'class' => 'LibraryBundle:Genre',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ))
            ->add('isbn', TextType::class, ['label' => 'ISBN'])
            ->add('cover', FileType::class, array('label' => 'Cover'))
            ->add('title')
            ->add('annotation')
            ->add('numberOfPages');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LibraryBundle\Entity\Book'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'librarybundle_book';
    }


}
