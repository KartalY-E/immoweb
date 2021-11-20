<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PropertyFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price', null, ['required' => false])
            ->add('bedroom', ChoiceType::class, [
                'choices'  => [
                    'Choose' => 0,
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '3 <' => '4',
                ],
            ])
            ->add('bathroom', ChoiceType::class, [
                'choices'  => [
                    'Choose' => 0,
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '3 <' => '4',
                ],
            ])
            ->add('city', ChoiceType::class, [
                'choices'  => [
                    'Choose' => 0,
                    'Antwerpen' => 'Antwerpen',
                    'Brussel' => 'Brussel',
                    'Leuven' => 'Leuven',
                    'Genk' => 'Genk',
                    'Gent' => 'Gent',
                ],
            ])
            ->add('propertyType')
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'save btn-outline-dark'],
                'label' => 'Search',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
