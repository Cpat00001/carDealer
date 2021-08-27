<?php

namespace App\Form;


use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('image', FileType::class, ['label' => 'Add Car Image', 'mapped' => false])
            ->add('description')
            ->add('Price')
            ->add('Value')
            ->add('AddNewCar', SubmitType::class)
            // ->add('save', SubmitType::class, ['label' => ' Add New Car'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
