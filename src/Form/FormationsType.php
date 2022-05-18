<?php

namespace App\Form;

use App\Entity\Formateurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


use App\Entity\Formations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class FormationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('theme')
            ->add('nom')
            ->add('dateDebut',DateType::class,[
                'widget' => 'single_text'
            ] )
            ->add('dateFin',DateType::class,[
                'widget' => 'single_text'
            ] )
            ->add('description')
            ->add('prix')
            ->add('idFormateur',EntityType::class,[
                'label' => 'Formateur',
                'class' => Formateurs::class,
                'choice_label' => function ($formateur) {
                    return  $formateur->toString();},
               
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formations::class,
        ]);
    }
}
