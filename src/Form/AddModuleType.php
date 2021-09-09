<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Modules;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('Duration')
            ->add('formation', EntityType::class, [
                'class'         => Formation::class,
                'choice_label'  => 'name',
                'multiple'      => true,
                'expanded'      => true,
                'by_reference'  => false,
            ])
            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Modules::class,
        ]);
    }
}
