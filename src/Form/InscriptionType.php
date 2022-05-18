<?php

namespace App\Form;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Formations;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $request = Request::createFromGlobals();
        $x=$request->query->get('idFormation');
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            
            ->add('mdp',PasswordType::class)
         
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
