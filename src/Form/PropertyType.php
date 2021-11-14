<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price')
            ->add('description')
            ->add('bedroom')
            ->add('bathroom')
            ->add('squareMeters')
            ->add('buildYear')
            ->add('city', ChoiceType::class, [
                'choices'  => [
                    'Antwerpen' => 'Antwerpen',
                    'Brussel' => 'Brussel',
                    'Leuven' => 'Leuven',
                    'Genk' => 'Genk',
                    'Gent' => 'Gent',
                ],
            ])
            ->add('street')
            ->add('propertyType')
            ->add('upload', FileType::class, [
                'label' => 'Upload your images',
                'mapped' => false,
                'required' => false,
                'multiple' => true
            ])

            ->add('images', EntityType::class, [

                'class' => Image::class,
                'query_builder' => function (EntityRepository $repository) use ($options) {
                    return $repository->createQueryBuilder('e')
                        ->setParameter('property_id', $options['property_id'])
                        ->where('e.property = :property_id')
                        ->orderBy('e.filename', 'ASC');
                },
                'mapped' => true,
                'required' => false,
                'choice_label' => 'original_filename',

                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
                'legacy_error_messages' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'property_id' => null
        ]);
    }
}
