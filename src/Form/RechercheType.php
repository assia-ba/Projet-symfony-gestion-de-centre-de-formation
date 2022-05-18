<?php

namespace App\Form;

use App\Entity\Formateurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


use App\Entity\Formations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('theme')
            ->add('dateDebut',DateType::class,[
                'widget' => 'single_text'
            ] )
            ->add('dateFin',DateType::class,[
                'widget' => 'single_text'
            ] )
            ->add('recherche', SubmitType::class)
            ;
    }
    }