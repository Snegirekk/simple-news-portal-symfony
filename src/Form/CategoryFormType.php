<?php

namespace App\Form;

use App\Dto\Category\EditableCategoryDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryFormType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('parentCategoryId', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Choose category',
                'choices' => $options['categories'],
                'label' => 'Parent category',
            ])
            ->add('submit', SubmitType::class);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditableCategoryDto::class,
            'validation_groups' => ['Default'],
            'categories' => [],
        ]);
    }
}
