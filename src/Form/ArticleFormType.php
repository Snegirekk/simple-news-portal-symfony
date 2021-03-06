<?php

namespace App\Form;

use App\Dto\Article\EditableArticleDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('announcement', TextareaType::class, [
                'attr' => [
                    'rows' => 3,
                ],
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'rows' => 10,
                ],
            ])
            ->add('isActive', CheckboxType::class, [
                'required' => false,
            ])
            ->add('categoryId', ChoiceType::class, [
                'choices' => $options['categories'],
                'label' => 'Category',
            ])
            ->add('submit', SubmitType::class);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditableArticleDto::class,
            'validation_groups' => ['Default'],
            'categories' => [],
        ]);
    }
}
